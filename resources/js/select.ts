/**
 * Enhanced selects with Tom Select, a port of js-utilities' select2-custom.js.
 *
 * `select.select2-basic`, `select.select2-ajax` and `select.select2-b-icon` read:
 * `data-placeholder`, `data-allow-clear`, `data-tags`, `data-minimum-results-for-search="Infinity"`
 * (no search box), `data-dropdown-parent-elem`, and for ajax selects `data-select-ajax-url`
 * (a URL, or a JSON object of URLs keyed by `data-selected-url`), `data-name-field`,
 * `data-id-field`, `data-minimum-input-length` (default 1), `data-per-page`, and
 * `data-select-parent` + `data-filter-field` to filter by another select's value.
 *
 * Cascades: `[data-select-child="#child"]` loads the child's options from its
 * `data-select-ajax-url` when the value changes (`[data-first]` loads them on page load,
 * `data-fallback` swaps in another field when there are none), and
 * `[data-ajax-child="#child"]` points an ajax child at the URL for the value.
 */
import TomSelect from "tom-select/base"
import clearButton from "tom-select/plugins/clear_button/plugin.js"
import removeButton from "tom-select/plugins/remove_button/plugin.js"
import virtualScroll from "tom-select/plugins/virtual_scroll/plugin.js"

import { all, autoInit, currentValue, data, escapeHtml, fire, flag, isBlank, once, picks, select, valueOf } from "./dom"
import { __ } from "./lang"
import { getJson, itemsOf, toOptions, withQuery, type Option, type Params } from "./remote"

TomSelect.define("clear_button", clearButton)
TomSelect.define("remove_button", removeButton)
TomSelect.define("virtual_scroll", virtualScroll)

export { TomSelect }

export const SELECTOR = "select.select2-basic, select.select2-ajax, select.select2-b-icon"

type Enhanced = HTMLSelectElement & { tomselect?: TomSelect }

type Escape = (value: string) => string

type Render = Record<string, (this: TomSelect, data: Record<string, unknown>, escape: Escape) => string | null>

interface RemotePagination {
  getUrl(query: string): unknown
  setNextUrl(query: string, next: unknown): void
  clearPagination(): void
}

/** The Tom Select instance of a select, if it has one. */
export function instanceOf(el: HTMLSelectElement): TomSelect | undefined {
  return (el as Enhanced).tomselect
}

function strings(): Render {
  return {
    loading: () => `<div class="loading">${escapeHtml(__("forms::strings.loading"))}</div>`,
    loading_more: () => `<div class="loading-more-results">${escapeHtml(__("forms::strings.loading"))}</div>`,
    no_more_results: () => null,
    option_create: (item) =>
      `<div class="create">${escapeHtml(__("forms::strings.add_option", { value: String(item.input ?? "") }))}</div>`,
  }
}

function iconRender(el: HTMLSelectElement): Render {
  const prefix = escapeHtml(el.getAttribute("data-icon-prefix") ?? "")
  const placeholder = el.getAttribute("data-placeholder") ?? ""

  const render = (item: Record<string, unknown>, escape: Escape): string => {
    const icon = String(item.value ?? "")
    const text = String(item.text ?? "")

    if (!icon) return `<div><span>${escape(placeholder || text)}</span></div>`

    return `<div><span><i class="${prefix} ${prefix}-${escape(icon)} select2-icon" aria-hidden="true"></i>${escape(text)}</span></div>`
  }

  return { option: render, item: render }
}

/** The ajax URL for the select: its own, or the one for `data-selected-url`, with `:value` filled in. */
export function resolveUrl(el: HTMLSelectElement): string {
  const urls = data(el, "select-ajax-url")
  let url = ""

  if (urls && typeof urls === "object" && !Array.isArray(urls)) {
    const map = urls as Record<string, string>
    const first = Object.values(map)[0] ?? ""
    url = map[el.getAttribute("data-selected-url") ?? ""] || first
  } else if (typeof urls === "string") {
    url = urls
  }

  const parent = filterParentOf(el)
  if (parent && url) url = url.replace(":value", encodeURIComponent(parentValue(parent)))

  return url
}

function filterParentOf(el: HTMLSelectElement): string | null {
  return el.getAttribute("data-select-parent") || el.getAttribute("data-filter-parent")
}

/** A parent's value as a string, `""` when nothing is selected. */
function parentValue(selector: string): string {
  const value = currentValue(select(selector))

  return Array.isArray(value) ? value.join(",") : value
}

/** The query select2-custom.js sent for a page of results. */
export function ajaxParams(el: HTMLSelectElement, page: number, term: string): Params {
  const idField = el.getAttribute("data-id-field") || "id"
  const nameField = el.getAttribute("data-name-field") || "name"
  const perPage = el.getAttribute("data-per-page")
  const parent = filterParentOf(el)
  const filterField = el.getAttribute("data-filter-field")

  const params: Params = { append: "", include: "", page, fields: `${idField},${nameField}` }

  if (perPage !== null && perPage !== "") params.per_page = perPage

  const filter: Params = {}
  if (term) filter.search = term
  if (parent && filterField) filter[filterField] = currentValue(select(parent))

  if (Object.keys(filter).length) params.filter = filter

  return params
}

function ajaxSettings(el: HTMLSelectElement): Record<string, unknown> {
  const idField = el.getAttribute("data-id-field") || "id"
  const nameField = el.getAttribute("data-name-field") || "name"
  const minimum = Number(el.getAttribute("data-minimum-input-length") ?? 1)
  const minLength = Number.isFinite(minimum) ? minimum : 1
  let failed = false

  return {
    firstUrl: () => 1,
    loadThrottle: 250,
    preload: minLength <= 0 ? "focus" : false,
    shouldLoad: (query: string) => query.length >= minLength,
    // The server has already filtered the results.
    score: () => () => 1,
    render: {
      no_results: () =>
        `<div class="no-results">${escapeHtml(__(failed ? "forms::strings.error_loading_options" : "forms::strings.no_results"))}</div>`,
    },
    load(this: TomSelect & RemotePagination, query: string, callback: (options?: Option[]) => void) {
      const page = Number(this.getUrl(query)) || 1
      const url = resolveUrl(el)
      failed = false

      if (!url) {
        callback([])
        return
      }

      getJson(withQuery(url, ajaxParams(el, page, query)))
        .then((body) => {
          const { items, more } = itemsOf(body)
          if (more) this.setNextUrl(query, page + 1)
          callback(toOptions(items, idField, nameField))
        })
        .catch(() => {
          failed = true
          callback([])
        })
    },
  }
}

/** Tom Select settings from the select's data attributes. */
export function settingsFor(el: HTMLSelectElement): Record<string, unknown> {
  const multiple = el.multiple
  const hideSearch = !multiple && String(data(el, "minimum-results-for-search")) === "Infinity"
  const plugins: Record<string, Record<string, unknown>> = {}

  if (multiple) {
    plugins.remove_button = { title: __("forms::strings.fileinput_remove_file") }
  } else if (flag(el, "allow-clear")) {
    plugins.clear_button = { title: escapeHtml(__("forms::strings.clear")) }
  }

  const render: Render = {
    ...strings(),
    no_results: () => `<div class="no-results">${escapeHtml(__("forms::strings.no_results"))}</div>`,
  }

  const settings: Record<string, unknown> = { plugins, render, maxOptions: null, create: flag(el, "tags") }

  const placeholder = el.getAttribute("data-placeholder") ?? el.getAttribute("placeholder")
  if (placeholder !== null) settings.placeholder = placeholder

  if (hideSearch) {
    settings.controlInput = null
    // Without a search box there's nowhere to show the placeholder, so the empty option shows it.
    settings.allowEmptyOption = !!el.querySelector('option[value=""]')
  }

  const dropdownParent = el.getAttribute("data-dropdown-parent-elem")
  if (dropdownParent && document.querySelector(dropdownParent)) settings.dropdownParent = dropdownParent

  if (el.classList.contains("select2-b-icon")) Object.assign(render, iconRender(el))

  if (el.classList.contains("select2-ajax")) {
    const { render: remoteRender, ...remote } = ajaxSettings(el)
    plugins.virtual_scroll = {}
    Object.assign(settings, remote)
    Object.assign(render, remoteRender)
  }

  return settings
}

/** Keeps Tom Select's disabled state in line with the select's, which other scripts change. */
function watchDisabled(el: HTMLSelectElement, ts: TomSelect): void {
  new MutationObserver(() => {
    if (ts.isDisabled === el.disabled) return

    if (el.disabled) ts.disable()
    else ts.enable()
  }).observe(el, { attributes: true, attributeFilter: ["disabled"] })
}

export function enhance(el: HTMLSelectElement): TomSelect {
  const existing = instanceOf(el)
  if (existing) return existing

  const classes = Array.from(el.classList)
  const ts = new TomSelect(el, settingsFor(el))

  // Tom Select copies the select's classes to its wrapper; select.css styles the
  // wrapper itself, so keep only the ones it reads.
  classes.forEach((name) => {
    if (name !== "is-invalid" && !name.startsWith("select2-")) ts.wrapper.classList.remove(name)
  })

  watchDisabled(el, ts)

  return ts
}

/** Re-reads the select's options and value into its Tom Select, after they're changed in the DOM. */
export function refresh(el: HTMLSelectElement): void {
  const ts = instanceOf(el)
  if (!ts) return

  const values = Array.from(el.selectedOptions).map((option) => option.value)

  ts.clearOptions(() => false)
  ts.clear(true)
  ts.sync()
  ts.setValue(values, true)

  if (el.disabled) ts.disable()
  else ts.enable()
}

/** Replaces the select's options (keeping its empty placeholder option) and sets its value. */
const placeholders = new WeakMap<HTMLSelectElement, Node | null>()

/** A copy of the select's empty placeholder option, as the page rendered it. */
function placeholderOf(el: HTMLSelectElement): Node | null {
  if (!placeholders.has(el)) {
    const option = el.querySelector('option[value=""]:not([data-forms-status])')
    placeholders.set(el, option ? option.cloneNode(true) : null)
  }

  return placeholders.get(el)?.cloneNode(true) ?? null
}

export function setOptions(el: HTMLSelectElement, options: Option[], value: string | string[] = ""): void {
  const keep = placeholderOf(el)

  el.replaceChildren(
    ...(keep ? [keep] : []),
    ...options.map((option) => {
      const node = document.createElement("option")
      node.value = option.value
      node.textContent = option.text
      return node
    }),
  )

  const values = Array.isArray(value) ? value : [value]
  Array.from(el.options).forEach((option) => {
    option.selected = values.includes(option.value) && (option.value !== "" || !el.multiple)
  })

  if (!values.some((item) => item !== "") && !keep && !el.multiple) el.selectedIndex = -1

  refresh(el)
}

/** One status option (loading, error) in place of the select's options. */
function setStatus(el: HTMLSelectElement, text: string): void {
  placeholderOf(el)

  const node = document.createElement("option")
  node.value = ""
  node.textContent = text
  node.setAttribute("data-forms-status", "")

  el.replaceChildren(node)
  refresh(el)
}

/** Empties an ajax select: its value, options and the pages it has loaded. */
export function reset(el: HTMLSelectElement): void {
  const ts = instanceOf(el) as (TomSelect & Partial<RemotePagination>) | undefined

  if (ts) {
    ts.clearPagination?.()
    ts.clear(true)
    ts.clearOptions(() => false)
    ts.loadedSearches = {}
  }

  // After Tom Select, which adds an empty option when it's cleared.
  el.replaceChildren()
}

/** The element to show or hide for a select: its Onu wrapper, its Tom Select, or itself. */
function visibleBox(el: HTMLSelectElement): HTMLElement {
  return (
    el.closest<HTMLElement>('[data-slot="native-select-wrapper"]') ??
    (instanceOf(el)?.wrapper as HTMLElement | undefined) ??
    el
  )
}

function setFallback(selector: string | null, enabled: boolean): void {
  select<HTMLElement>(selector).forEach((fallback) => {
    fallback.hidden = !enabled
    if ("disabled" in fallback) (fallback as HTMLInputElement).disabled = !enabled
  })
}

const requests = new WeakMap<HTMLSelectElement, AbortController>()

async function loadChild(child: HTMLSelectElement, value: string, disableChild: boolean): Promise<void> {
  const fallback = child.getAttribute("data-fallback")
  const idField = child.getAttribute("data-id-field") || "id"
  const nameField = child.getAttribute("data-name-field") || "name"
  const filter = child.getAttribute("data-filter-field")
  const url = (child.getAttribute("data-select-ajax-url") ?? "").replace(":value", encodeURIComponent(value))
  const childValue = valueOf(child)

  const params: Params = { fields: `${idField},${nameField}`, per_page: -1, include: "", append: "" }
  if (filter) params.filter = { [filter]: value }

  requests.get(child)?.abort()
  const controller = new AbortController()
  requests.set(child, controller)

  child.disabled = true
  setStatus(child, __("forms::strings.loading"))

  let options: Option[]
  try {
    options = toOptions(itemsOf(await getJson(withQuery(url, params), controller.signal)).items, idField, nameField)
  } catch {
    if (controller.signal.aborted) return
    setStatus(child, __("forms::strings.error_loading_options"))
    return
  }

  if (controller.signal.aborted) return

  setOptions(child, options, childValue)

  if (fallback) {
    const any = options.length > 0
    setFallback(fallback, !any)
    visibleBox(child).hidden = !any
    child.disabled = !any
  } else {
    child.disabled = disableChild && !options.length
  }

  refresh(child)
  fire(child)
}

/** `[data-select-child]`: load (or empty) the children for the select's value. */
export function loadChildren(parent: HTMLSelectElement): Promise<void[]> {
  const value = valueOf(parent)
  const children = select<HTMLSelectElement>(parent.getAttribute("data-select-child"))
  const disableChild = flag(parent, "disable-child")

  if (!isBlank(value)) {
    const text = Array.isArray(value) ? value.join(",") : value
    return Promise.all(children.map((child) => loadChild(child, text, disableChild)))
  }

  const parentFallback = parent.getAttribute("data-fallback")
  const parentFallbackEnabled = select<HTMLInputElement>(parentFallback).some((el) => !el.disabled)

  children.forEach((child) => {
    requests.get(child)?.abort()

    const fallback = child.getAttribute("data-fallback")

    child.replaceChildren()
    child.disabled = true
    refresh(child)

    if (fallback) {
      visibleBox(child).hidden = true
      select<HTMLElement>(fallback).forEach((el) => {
        el.hidden = false
        if ("disabled" in el) (el as HTMLInputElement).disabled = !(parentFallback && parentFallbackEnabled)
      })
    }

    fire(child)
  })

  return Promise.resolve([])
}

/** `[data-ajax-child]`: point the ajax children at the URL for the select's value. */
export function updateAjaxChildren(parent: HTMLSelectElement): void {
  const raw = valueOf(parent)
  const value = Array.isArray(raw) ? raw.join(",") : raw

  select<HTMLSelectElement>(parent.getAttribute("data-ajax-child")).forEach((child) => {
    if (value) {
      if (child.getAttribute("data-selected-url") !== value) reset(child)
      child.setAttribute("data-selected-url", value)
      child.disabled = false
    } else {
      reset(child)
      child.removeAttribute("data-selected-url")
      child.disabled = true
    }

    fire(child)
  })
}

const filterValues = new WeakMap<HTMLSelectElement, string>()

const FILTERED = "select.select2-ajax[data-select-parent], select.select2-ajax[data-filter-parent]"

/** An ajax select filtered by a parent: remember the parent's value, disabled while it's empty. */
function bindFilterParent(child: HTMLSelectElement): void {
  const value = parentValue(filterParentOf(child) ?? "")

  filterValues.set(child, value)
  child.disabled = value === ""
}

function onParentChange(target: Element): void {
  document.querySelectorAll<HTMLSelectElement>(FILTERED).forEach((child) => {
    const selector = filterParentOf(child)
    if (child === target || !filterValues.has(child) || !picks(selector, target)) return

    const value = parentValue(selector ?? "")
    const changed = value !== filterValues.get(child)

    filterValues.set(child, value)
    if (changed) reset(child)
    child.disabled = value === ""

    // let any grandchildren cascade
    if (changed) fire(child)
  })
}

function onChange(event: Event): void {
  const target = event.target
  if (!(target instanceof Element)) return

  if (target instanceof HTMLSelectElement) {
    if (target.hasAttribute("data-ajax-child")) updateAjaxChildren(target)
    if (target.hasAttribute("data-select-child")) void loadChildren(target)
  }

  onParentChange(target)
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("change", onChange)
    listening = true
  }

  all<HTMLSelectElement>(root, FILTERED).forEach((el) => {
    if (once(el, "filter-parent")) bindFilterParent(el)
  })

  all<HTMLSelectElement>(root, SELECTOR).forEach((el) => {
    if (once(el, "select")) enhance(el)
  })

  all<HTMLSelectElement>(root, "select[data-ajax-child]").forEach((el) => {
    if (once(el, "ajax-child")) updateAjaxChildren(el)
  })

  all<HTMLSelectElement>(root, "select[data-first][data-select-child]:not(.no-auto-trigger)").forEach((el) => {
    if (once(el, "first")) void loadChildren(el)
  })
}

autoInit(init)
