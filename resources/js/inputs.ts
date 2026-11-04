/**
 * Input helpers.
 *
 * - `textarea[data-auto-resize]` grows (and shrinks) with its content.
 * - `input[data-decimals="2"]` rounds its number to that many decimals on change and blur.
 * - `[data-date-clear="#id"]` clears that input (and its flatpickr calendar) and fires `change`.
 */
import { all, fire, once, select } from "./dom"

interface WithFlatpickr {
  _flatpickr?: { clear: (triggerChange?: boolean) => void }
}

export function resize(textarea: HTMLTextAreaElement): void {
  const style = getComputedStyle(textarea)
  const borders =
    style.boxSizing === "border-box"
      ? (parseFloat(style.borderTopWidth) || 0) + (parseFloat(style.borderBottomWidth) || 0)
      : -((parseFloat(style.paddingTop) || 0) + (parseFloat(style.paddingBottom) || 0))

  textarea.style.height = "auto"
  textarea.style.height = `${textarea.scrollHeight + borders}px`
}

export function round(input: HTMLInputElement): void {
  const decimals = Number(input.getAttribute("data-decimals"))
  const value = input.value.trim()

  if (value === "" || !Number.isInteger(decimals) || decimals < 0) return

  const number = Number(value)
  if (!Number.isFinite(number)) return

  const rounded = number.toFixed(decimals)
  if (rounded !== input.value) input.value = rounded
}

export function clearDate(input: HTMLInputElement): void {
  if (input.disabled || input.readOnly) return

  const picker = (input as HTMLInputElement & WithFlatpickr)._flatpickr

  if (picker) {
    // flatpickr fires change itself.
    picker.clear(true)
    return
  }

  input.value = ""
  fire(input, "input")
  fire(input, "change")
}

function onInput(event: Event): void {
  const target = event.target
  if (target instanceof HTMLTextAreaElement && target.hasAttribute("data-auto-resize")) resize(target)
}

function onRound(event: Event): void {
  const target = event.target
  if (target instanceof HTMLInputElement && target.hasAttribute("data-decimals")) round(target)
}

function onClick(event: MouseEvent): void {
  const button = event.target instanceof Element ? event.target.closest("[data-date-clear]") : null
  if (!button) return

  event.preventDefault()

  const [input] = select(button.getAttribute("data-date-clear"))
  if (input instanceof HTMLInputElement) clearDate(input)
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("input", onInput)
    document.addEventListener("change", onRound)
    document.addEventListener("focusout", onRound)
    document.addEventListener("click", onClick)
    listening = true
  }

  all<HTMLTextAreaElement>(root, "textarea[data-auto-resize]").forEach((textarea) => {
    if (!once(textarea, "auto-resize")) return

    textarea.style.overflowY = "hidden"
    resize(textarea)
  })
}
