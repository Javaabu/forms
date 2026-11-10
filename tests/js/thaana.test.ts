import { describe, expect, it } from "vitest"

import { controllerFor, init } from "../../resources/js/thaana"
import { $, html } from "./helpers"

function type(el: HTMLInputElement | HTMLTextAreaElement, text: string): void {
  for (const data of text) {
    const event = new InputEvent("beforeinput", { inputType: "insertText", data, bubbles: true, cancelable: true })
    if (el.dispatchEvent(event)) {
      el.setRangeText(data, el.selectionStart ?? el.value.length, el.selectionEnd ?? el.value.length, "end")
    }
  }
}

describe("thaana", () => {
  it("types Thaana from a Latin keyboard", () => {
    html(
      `<input id="name" data-thaana dir="rtl" lang="dv"><textarea id="notes" data-thaana></textarea><input id="plain">`,
    )
    init()

    type($<HTMLInputElement>("#name"), "mAle")
    expect($<HTMLInputElement>("#name").value).toBe("މާލެ")

    type($<HTMLTextAreaElement>("#notes"), "ali")
    expect($<HTMLTextAreaElement>("#notes").value).toBe("ަލި")

    type($<HTMLInputElement>("#plain"), "ali")
    expect($<HTMLInputElement>("#plain").value).toBe("ali")
  })

  it("uses the field's keymap and attaches once", () => {
    html(
      `<input id="a" data-thaana data-thaana-keymap="typewriter"><input id="b" data-thaana data-thaana-keymap="nope">`,
    )
    init()
    const controller = controllerFor($("#a"))
    init()

    expect(controllerFor($("#a"))).toBe(controller)
    type($<HTMLInputElement>("#a"), "q")
    expect($<HTMLInputElement>("#a").value).toBe("ޫ")
    type($<HTMLInputElement>("#b"), "q")
    expect($<HTMLInputElement>("#b").value).toBe("ް")
  })

  it("can be turned off", () => {
    html(`<input id="a" data-thaana>`)
    init()
    controllerFor($("#a"))?.setEnabled(false)
    type($<HTMLInputElement>("#a"), "a")
    expect($<HTMLInputElement>("#a").value).toBe("a")
  })
})
