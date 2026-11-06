import { describe, expect, it, vi } from "vitest"

import { init, setBusy } from "../../resources/js/submit"
import { $, flush, html } from "./helpers"

const button = (id: string, extra = "") =>
  `<button id="${id}" type="submit" class="animate-submit" ${extra}><svg data-slot="button-spinner" hidden></svg>ފޮނުވާ</button>`

function submit(form: HTMLFormElement, submitter?: HTMLElement): SubmitEvent {
  const event = new SubmitEvent("submit", { bubbles: true, cancelable: true, submitter })
  form.dispatchEvent(event)
  return event
}

describe("submit spinner", () => {
  it("shows the clicked button's spinner and disables it after the submit event", async () => {
    html(`<form id="f">${button("save")}${button("other")}</form>`)
    init()

    const event = submit($("#f"), $("#save"))
    expect(event.defaultPrevented).toBe(false)
    expect($<HTMLButtonElement>("#save").disabled).toBe(false)

    await flush()
    expect($<HTMLButtonElement>("#save").disabled).toBe(true)
    expect($("#save").getAttribute("aria-busy")).toBe("true")
    expect($("#save svg").hasAttribute("hidden")).toBe(false)
    expect($<HTMLButtonElement>("#other").disabled).toBe(false)
  })

  it("animates every animated button when there's no submitter", async () => {
    html(`<form id="f">${button("a")}</form>${button("b", 'form="f"')}`)
    init()

    submit($("#f"))
    await flush()
    expect($<HTMLButtonElement>("#a").disabled).toBe(true)
    expect($<HTMLButtonElement>("#b").disabled).toBe(true)
  })

  it("does nothing for plain submitters or cancelled submissions", async () => {
    html(`<form id="f"><button id="plain">ފޮނުވާ</button>${button("a")}</form>`)
    init()

    submit($("#f"), $("#plain"))
    await flush()
    expect($<HTMLButtonElement>("#a").disabled).toBe(false)

    $("#f").addEventListener("submit", (event) => event.preventDefault(), { once: true })
    submit($("#f"), $("#a"))
    await flush()
    expect($<HTMLButtonElement>("#a").disabled).toBe(false)

    document.dispatchEvent(new SubmitEvent("submit"))
  })

  it("restores buttons when the page comes back from the cache", async () => {
    html(`<form id="f">${button("a")}</form>`)
    init()

    submit($("#f"), $("#a"))
    await flush()

    window.dispatchEvent(new PageTransitionEvent("pageshow", { persisted: false }))
    expect($<HTMLButtonElement>("#a").disabled).toBe(true)

    window.dispatchEvent(new PageTransitionEvent("pageshow", { persisted: true }))
    expect($<HTMLButtonElement>("#a").disabled).toBe(false)
    expect($("#a").hasAttribute("aria-busy")).toBe(false)
    expect($("#a svg").hasAttribute("hidden")).toBe(true)
  })

  it("sets links busy without disabling them", () => {
    html(`<a id="l" class="animate-submit"><svg data-slot="button-spinner" hidden></svg></a>`)
    setBusy($("#l"), true)
    expect($("#l").getAttribute("aria-busy")).toBe("true")
  })
})

describe("focus on error", () => {
  it("focuses the error summary", () => {
    html(`<form data-focus-on-error><div id="summary" tabindex="-1" data-forms-summary>ގޯސް</div>
      <input id="name" aria-invalid="true"></form>`)
    init()
    expect(document.activeElement).toBe($("#summary"))
  })

  it("focuses the first invalid control without a summary", () => {
    html(`<form data-focus-on-error><input id="ok"><input id="name" aria-invalid="true"></form>`)
    init()
    expect(document.activeElement).toBe($("#name"))
  })

  it("doesn't steal focus or focus forms without errors", () => {
    html(`<input id="auto"><form data-focus-on-error><input id="name" aria-invalid="true"></form>
      <form data-focus-on-error id="clean"><input></form>`)
    $("#auto").focus()
    init()
    expect(document.activeElement).toBe($("#auto"))

    $("#auto").blur()
    const focus = vi.spyOn(HTMLElement.prototype, "focus")
    init()
    expect(focus).not.toHaveBeenCalled()
  })
})
