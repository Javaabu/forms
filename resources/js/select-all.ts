/**
 * Select all: `<input type="checkbox" data-all="users">` checks and unchecks every
 * enabled `<input type="checkbox" data-check="users">`, and shows whether all, some
 * (indeterminate) or none of them are checked.
 */
import { all, once } from "./dom"

function boxes(attribute: "data-all" | "data-check", name: string): HTMLInputElement[] {
  return Array.from(document.querySelectorAll<HTMLInputElement>(`input[type="checkbox"][${attribute}]`)).filter(
    (box) => box.getAttribute(attribute) === name,
  )
}

/** Brings the `data-all` boxes for `name` in line with its rows. */
export function sync(name: string): void {
  const rows = boxes("data-check", name).filter((box) => !box.disabled)
  const checked = rows.filter((box) => box.checked).length

  boxes("data-all", name).forEach((box) => {
    box.checked = rows.length > 0 && checked === rows.length
    box.indeterminate = checked > 0 && checked < rows.length
  })
}

function onChange(event: Event): void {
  const target = event.target
  if (!(target instanceof HTMLInputElement) || target.type !== "checkbox") return

  const allName = target.getAttribute("data-all")
  if (allName !== null) {
    boxes("data-check", allName).forEach((box) => {
      if (!box.disabled) box.checked = target.checked
    })
    sync(allName)
    return
  }

  const rowName = target.getAttribute("data-check")
  if (rowName !== null) sync(rowName)
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("change", onChange)
    listening = true
  }

  all<HTMLInputElement>(root, 'input[type="checkbox"][data-all]').forEach((box) => {
    if (once(box, "select-all")) sync(box.getAttribute("data-all") ?? "")
  })
}
