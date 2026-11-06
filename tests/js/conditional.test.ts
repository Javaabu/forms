import { describe, expect, it } from "vitest"

import { init } from "../../resources/js/conditional"
import { $, fire, html } from "./helpers"

const input = (selector: string) => $<HTMLInputElement>(selector)

describe("conditional display", () => {
  it("enables a section when another field has the value", () => {
    html(`
      <select id="type"><option value="">-</option><option value="island">ރަށް</option></select>
      <div id="section" data-enable-elem="#type" data-enable-section-value="island">
        <input id="name" value="މާލެ"><textarea id="notes"></textarea><select id="atoll"></select>
      </div>`)

    init()
    expect(input("#name").disabled).toBe(true)
    expect(input("#name").classList.contains("auto-disabled")).toBe(true)
    expect($<HTMLTextAreaElement>("#notes").disabled).toBe(true)
    expect($<HTMLSelectElement>("#atoll").disabled).toBe(true)
    expect($("#section").hidden).toBe(false)

    $<HTMLSelectElement>("#type").value = "island"
    fire($("#type"))
    expect(input("#name").disabled).toBe(false)
    expect(input("#name").classList.contains("auto-disabled")).toBe(false)
  })

  it("leaves fields the server disabled alone", () => {
    html(`
      <select id="type"><option value="a">a</option><option value="b">b</option></select>
      <div data-enable-elem="#type" data-enable-section-value="a">
        <input id="locked" disabled><input id="open">
      </div>`)

    init()
    $<HTMLSelectElement>("#type").value = "b"
    fire($("#type"))
    $<HTMLSelectElement>("#type").value = "a"
    fire($("#type"))

    expect(input("#locked").disabled).toBe(true)
    expect(input("#open").disabled).toBe(false)
  })

  it("matches any of a JSON array of values, hides and inverts", () => {
    html(`
      <input type="radio" name="kind" value="1" id="one"><input type="radio" name="kind" value="2" id="two" checked>
      <input type="radio" name="kind" value="3" id="three">
      <div id="section" data-enable-elem="[name=kind]" data-enable-section-value='["1","3"]' data-hide-fields="true" data-disable="true">
        <input id="field">
      </div>`)

    init()
    expect($("#section").hidden).toBe(false)
    expect(input("#field").disabled).toBe(false)

    input("#three").checked = true
    fire(input("#three"))
    expect($("#section").hidden).toBe(true)
    expect(input("#field").disabled).toBe(true)
  })

  it("compares numbers loosely and reads multiple selects", () => {
    html(`
      <select id="ids" multiple><option value="1">1</option><option value="2">2</option></select>
      <div id="section" data-enable-elem="#ids" data-enable-section-value="2" data-hide-fields="true"><input id="f"></div>`)

    init()
    expect($("#section").hidden).toBe(true)

    $<HTMLSelectElement>("#ids").options[1]!.selected = true
    fire($("#ids"))
    expect($("#section").hidden).toBe(false)
  })

  it("ignores sections whose element is missing", () => {
    html(`<div id="section" data-enable-elem="#nope" data-enable-section-value="1"><input id="f"></div>
      <div data-enable-section-checkbox="#nope"><input id="g"></div>`)

    init()
    expect(input("#f").disabled).toBe(false)
    expect(input("#g").disabled).toBe(false)
  })

  it("enables a section while a checkbox is checked", () => {
    html(`
      <input type="checkbox" id="agree">
      <div id="section" data-enable-section-checkbox="#agree" data-hide-fields="true">
        <input id="f"><button id="b" type="button">ފޮނުވާ</button>
      </div>`)

    init()
    expect(input("#f").disabled).toBe(true)
    expect($<HTMLButtonElement>("#b").disabled).toBe(true)
    expect($("#section").hidden).toBe(true)

    input("#agree").checked = true
    fire(input("#agree"))
    expect(input("#f").disabled).toBe(false)
    expect($<HTMLButtonElement>("#b").disabled).toBe(false)
    expect($("#section").hidden).toBe(false)
  })

  it("disables a section while a checkbox is checked, with data-disable", () => {
    html(`<input type="checkbox" id="same" checked>
      <div data-enable-section-checkbox="#same" data-disable="true"><input id="f"></div>`)

    init()
    expect(input("#f").disabled).toBe(true)
  })

  it("toggles fields with data-toggle-checkbox", () => {
    html(`<input type="checkbox" id="c" data-toggle-checkbox="#a, #b"><input id="a"><input id="b">`)

    init()
    expect(input("#a").disabled).toBe(false)

    input("#c").checked = true
    fire(input("#c"))
    expect(input("#a").disabled).toBe(true)
    expect(input("#b").disabled).toBe(true)
  })

  it("enables and shows fields with data-enable-checkbox", () => {
    html(`
      <input type="checkbox" id="c" data-enable-checkbox="#fields">
      <div id="fields"><input id="a"><select id="s"></select></div>`)

    init()
    expect($("#fields").hidden).toBe(true)
    expect(input("#a").disabled).toBe(true)

    input("#c").checked = true
    fire(input("#c"))
    expect($("#fields").hidden).toBe(false)
    expect(input("#a").disabled).toBe(false)
    expect($<HTMLSelectElement>("#s").disabled).toBe(false)
  })

  it("inverts data-enable-checkbox with data-disable", () => {
    html(`<input type="checkbox" id="c" data-enable-checkbox="#fields" data-disable="true">
      <div id="fields"><input id="a"></div>`)

    init()
    expect(input("#a").disabled).toBe(false)
    expect($("#fields").hidden).toBe(false)
  })

  it("disables fields while a select has a value", () => {
    html(`
      <select id="s" data-disable-on-select="#fields" data-hide-fields="true">
        <option value="">ނެތް</option><option value="1">އެއް</option>
      </select>
      <div id="fields"><input id="a"></div>`)

    init()
    expect(input("#a").disabled).toBe(false)
    expect($("#fields").hidden).toBe(false)

    $<HTMLSelectElement>("#s").value = "1"
    fire($("#s"))
    expect(input("#a").disabled).toBe(true)
    expect($("#fields").hidden).toBe(true)
  })

  it("is idempotent", () => {
    html(`<input type="checkbox" id="c" data-toggle-checkbox="#a"><input id="a">`)

    init()
    input("#a").disabled = true
    init()
    expect(input("#a").disabled).toBe(true)
    expect(input("#c").getAttribute("data-forms-ready")).toBe("toggle-checkbox")
  })

  it("ignores events from non-elements", () => {
    init()
    document.dispatchEvent(new Event("change"))
  })
})
