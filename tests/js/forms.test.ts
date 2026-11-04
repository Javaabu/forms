import { describe, expect, it } from "vitest"

import * as forms from "../../resources/js/forms"
import { $, fire, html } from "./helpers"

describe("forms entry", () => {
  it("initialises every core behaviour", () => {
    html(`
      <input type="checkbox" id="c" data-toggle-checkbox="#a"><input id="a">
      <input type="checkbox" id="all" data-all="x"><input type="checkbox" id="r" data-check="x" checked>
      <textarea id="t" data-auto-resize="true"></textarea>
      <input id="th" data-thaana>
      <dialog class="forms-dialog" id="d"></dialog>`)

    forms.init()

    expect($<HTMLInputElement>("#all").checked).toBe(true)
    expect($("#t").getAttribute("data-forms-ready")).toBe("auto-resize")
    expect($("#th").getAttribute("data-forms-ready")).toBe("thaana")
    expect($("#d").getAttribute("data-state")).toBe("closed")

    $<HTMLInputElement>("#c").checked = true
    fire($("#c"))
    expect($<HTMLInputElement>("#a").disabled).toBe(true)
  })

  it("exports the modules", () => {
    expect(Object.keys(forms).sort()).toEqual(
      ["conditional", "init", "inputs", "selectAll", "sortable", "submit", "thaana", "widgets"].sort(),
    )
  })
})
