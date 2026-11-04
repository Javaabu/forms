/**
 * Form submission helpers.
 *
 * - Submit spinner: when a form is submitted, its `.animate-submit` button (the one
 *   clicked, or all of them when there's no submitter) shows its
 *   `svg[data-slot="button-spinner"]`, gets `aria-busy="true"` and is disabled once
 *   the submit event is over, so it can't be pressed twice. Submission isn't blocked,
 *   and nothing happens when another handler cancels the submit.
 * - Focus on error: a `form[data-focus-on-error]` focuses its error summary
 *   (`[data-forms-summary]`), or else its first `[aria-invalid="true"]` control, on load.
 */
import { all, once } from "./dom"

const busy = new Set<HTMLElement>()

function animated(form: HTMLFormElement, submitter: HTMLElement | null): HTMLElement[] {
  if (submitter) return submitter.classList.contains("animate-submit") ? [submitter] : []

  return Array.from(form.elements).filter(
    (el): el is HTMLElement => el instanceof HTMLElement && el.classList.contains("animate-submit"),
  )
}

export function setBusy(button: HTMLElement, isBusy: boolean): void {
  button.querySelectorAll<SVGElement>('[data-slot="button-spinner"]').forEach((spinner) => {
    spinner.toggleAttribute("hidden", !isBusy)
  })

  if (isBusy) {
    button.setAttribute("aria-busy", "true")
    busy.add(button)
  } else {
    button.removeAttribute("aria-busy")
    busy.delete(button)
  }

  if (button instanceof HTMLButtonElement || button instanceof HTMLInputElement) button.disabled = isBusy
}

function onSubmit(event: SubmitEvent): void {
  const form = event.target
  if (!(form instanceof HTMLFormElement)) return

  const buttons = animated(form, event.submitter ?? null)
  if (!buttons.length) return

  // After the event: the submitter's name and value are already in the form data,
  // and we know whether a later handler cancelled the submission.
  setTimeout(() => {
    if (event.defaultPrevented) return
    buttons.forEach((button) => setBusy(button, true))
  }, 0)
}

/** Pages restored from the back/forward cache get their buttons back. */
function onPageShow(event: PageTransitionEvent): void {
  if (event.persisted) Array.from(busy).forEach((button) => setBusy(button, false))
}

/** Focuses the form's first error, unless something else (autofocus, another form) has focus already. */
function focusOnError(form: HTMLFormElement): void {
  const active = document.activeElement
  if (active && active !== document.body && active !== document.documentElement) return

  const target =
    form.querySelector<HTMLElement>("[data-forms-summary]") ?? form.querySelector<HTMLElement>('[aria-invalid="true"]')
  if (!target) return

  target.focus()
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("submit", onSubmit)
    window.addEventListener("pageshow", onPageShow)
    listening = true
  }

  all<HTMLFormElement>(root, "form[data-focus-on-error]").forEach((form) => {
    if (once(form, "focus-on-error")) focusOnError(form)
  })
}
