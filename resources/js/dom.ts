/** Small DOM helpers shared by the modules. */

export type Init = (root?: ParentNode) => void

/** Runs `fn` once the DOM is ready (straight away if it already is). */
export function onReady(fn: () => void): void {
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", fn, { once: true })
  } else {
    fn()
  }
}

/**
 * Runs `init(document)` when the DOM is ready, and again (debounced) whenever
 * elements are added to the page, so content loaded later is enhanced too.
 * Add `data-forms-manual` to `<html>` to call the `init()` functions yourself.
 */
export function autoInit(init: Init, delay = 50): void {
  if (typeof document === "undefined" || document.documentElement.hasAttribute("data-forms-manual")) return

  onReady(() => {
    init(document)

    let timer: ReturnType<typeof setTimeout> | undefined
    const observer = new MutationObserver((records) => {
      const added = records.some((record) => Array.from(record.addedNodes).some((node) => node.nodeType === 1))
      if (!added) return

      clearTimeout(timer)
      timer = setTimeout(() => init(document), delay)
    })

    observer.observe(document.body, { childList: true, subtree: true })
  })
}

/**
 * Marks `el` as enhanced by `feature` in its `data-forms-ready` attribute.
 * Returns false when it already was, so `init()` can run any number of times.
 */
export function once(el: Element, feature: string): boolean {
  const ready = (el.getAttribute("data-forms-ready") ?? "").split(" ").filter(Boolean)
  if (ready.includes(feature)) return false

  ready.push(feature)
  el.setAttribute("data-forms-ready", ready.join(" "))

  return true
}

/** Every element in `root` (and `root` itself) that matches `selector`. */
export function all<T extends Element = HTMLElement>(root: ParentNode, selector: string): T[] {
  const found = Array.from(root.querySelectorAll<T>(selector))

  if (root instanceof Element && root.matches(selector)) found.unshift(root as unknown as T)

  return found
}

/** `document.querySelectorAll()` that returns nothing for an invalid or empty selector. */
export function select<T extends Element = HTMLElement>(selector: string | null | undefined): T[] {
  if (!selector) return []

  try {
    return Array.from(document.querySelectorAll<T>(selector))
  } catch {
    return []
  }
}

/**
 * A data attribute read the way jQuery's `.data()` did: `"true"` and `"false"`
 * become booleans, numbers become numbers, JSON arrays and objects are parsed.
 */
export function data(el: Element, name: string): unknown {
  const raw = el.getAttribute(`data-${name}`)
  if (raw === null) return undefined
  if (raw === "true") return true
  if (raw === "false") return false
  if (raw === "null") return null
  if (raw !== "" && String(Number(raw)) === raw) return Number(raw)

  if (/^[[{]/.test(raw)) {
    try {
      return JSON.parse(raw) as unknown
    } catch {
      return raw
    }
  }

  return raw
}

/** Whether a data attribute is set to something truthy, as `$(el).data(name)` would be. */
export function flag(el: Element, name: string): boolean {
  return !!data(el, name)
}

/** Fires a bubbling event, like jQuery's `.trigger()`. */
export function fire(el: EventTarget, type = "change"): void {
  el.dispatchEvent(new Event(type, { bubbles: true }))
}

/** Escapes text for use in HTML. */
export function escapeHtml(value: unknown): string {
  return String(value ?? "")
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;")
}

/** Whether the element is laid out right to left (its own `dir`, an ancestor's or the document's). */
export function isRtl(el: Element = document.documentElement): boolean {
  const dir = el.closest("[dir]")?.getAttribute("dir")?.toLowerCase()

  return dir === "rtl"
}

export type FormControl = HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement | HTMLButtonElement

/** Disables a control and marks it, so only controls we disabled are enabled again. */
export function autoDisable(control: FormControl): void {
  control.disabled = true
  control.classList.add("auto-disabled")
}

export function autoEnable(control: FormControl): void {
  control.disabled = false
  control.classList.remove("auto-disabled")
}

/** The value of a control as jQuery's `.val()` returned it: an array for a multiple select. */
export function valueOf(el: Element | undefined | null): string | string[] {
  if (el instanceof HTMLSelectElement && el.multiple) {
    return Array.from(el.selectedOptions).map((option) => option.value)
  }

  if (el instanceof HTMLInputElement || el instanceof HTMLSelectElement || el instanceof HTMLTextAreaElement) {
    return el.value
  }

  return ""
}

/** Whether a value from `valueOf()` is empty. */
export function isBlank(value: string | string[]): boolean {
  return Array.isArray(value) ? value.length === 0 : value === ""
}

/** The value of a set of controls: the checked radio's, the checked checkboxes', or the first control's. */
export function currentValue(controls: Element[]): string | string[] {
  const inputs = controls.filter((el): el is HTMLInputElement => el instanceof HTMLInputElement)

  if (inputs.length && inputs.every((el) => el.type === "radio")) {
    return inputs.find((el) => el.checked)?.value ?? ""
  }

  if (inputs.length && inputs.every((el) => el.type === "checkbox")) {
    return inputs.filter((el) => el.checked).map((el) => el.value)
  }

  return valueOf(controls[0])
}

/** Whether `el` is one of the elements `selector` picks (false for an invalid selector). */
export function picks(selector: string | null | undefined, el: Element): boolean {
  if (!selector) return false

  try {
    return el.matches(selector)
  } catch {
    return false
  }
}
