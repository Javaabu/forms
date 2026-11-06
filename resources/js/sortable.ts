/**
 * Sortable tables, a port of js-utilities' sortable.js (the form sort part).
 *
 * In `table[data-form-sortable="#filter"]`, clicking a `th[data-sort-field="name"]`
 * (or pressing Enter or Space on it) sets the filter form's hidden `orderby` and
 * `order` inputs (ASC, or DESC when the heading is already `sorting_asc`) and submits
 * the form. The heading's `sorting` / `sorting_asc` / `sorting_desc` class and
 * `aria-sort` are updated straight away, as the server renders them after the reload.
 */
import { all, once, select } from "./dom"

const HEADING = "[data-form-sortable] [data-sort-field]"

const SORT_CLASSES = ["sorting", "sorting_asc", "sorting_desc"]

type Order = "ASC" | "DESC"

function ariaSort(heading: Element): "ascending" | "descending" | "none" {
  if (heading.classList.contains("sorting_asc")) return "ascending"
  if (heading.classList.contains("sorting_desc")) return "descending"

  return "none"
}

function formFor(heading: Element): HTMLFormElement | null {
  const selector = heading.closest("[data-form-sortable]")?.getAttribute("data-form-sortable")
  const [form] = select(selector ? `form${selector}` : "")

  return form instanceof HTMLFormElement ? form : null
}

/** The form's hidden input called `name`, added when the form doesn't have one. */
function hidden(form: HTMLFormElement, name: string): HTMLInputElement {
  const existing = Array.from(form.elements).find(
    (el): el is HTMLInputElement => el instanceof HTMLInputElement && el.name === name,
  )
  if (existing) return existing

  const input = document.createElement("input")
  input.type = "hidden"
  input.name = name
  form.appendChild(input)

  return input
}

function setClasses(heading: Element, order: Order): void {
  const table = heading.closest("[data-form-sortable]")

  table?.querySelectorAll("[data-sort-field]").forEach((other) => {
    other.classList.remove(...SORT_CLASSES)
    other.classList.add("sorting")
    other.setAttribute("aria-sort", "none")
  })

  heading.classList.remove("sorting")
  heading.classList.add(order === "ASC" ? "sorting_asc" : "sorting_desc")
  heading.setAttribute("aria-sort", order === "ASC" ? "ascending" : "descending")
}

/** Sorts the heading's form by its field: ascending, or descending when it already is ascending. */
export function sort(heading: Element): void {
  const form = formFor(heading)
  if (!form) return

  const order: Order = heading.classList.contains("sorting_asc") ? "DESC" : "ASC"

  hidden(form, "orderby").value = heading.getAttribute("data-sort-field") ?? ""
  hidden(form, "order").value = order
  setClasses(heading, order)

  if (typeof form.requestSubmit === "function") form.requestSubmit()
  else form.submit()
}

function onClick(event: MouseEvent): void {
  const target = event.target
  const heading = target instanceof Element ? target.closest(HEADING) : null
  if (!heading) return

  // Links, buttons and checkboxes inside the heading keep working.
  const control = (target as Element).closest("a, button, input, select, textarea")
  if (control && heading.contains(control)) return

  event.preventDefault()
  sort(heading)
}

function onKeyDown(event: KeyboardEvent): void {
  if (event.key !== "Enter" && event.key !== " ") return

  const target = event.target
  if (!(target instanceof Element) || !target.matches(HEADING)) return

  event.preventDefault()
  sort(target)
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("click", onClick)
    document.addEventListener("keydown", onKeyDown)
    listening = true
  }

  all(root, HEADING).forEach((heading) => {
    if (!once(heading, "sortable")) return

    if (!heading.hasAttribute("tabindex")) heading.tabIndex = 0
    if (!heading.hasAttribute("aria-sort")) heading.setAttribute("aria-sort", ariaSort(heading))
  })
}
