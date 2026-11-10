import { describe, expect, it } from "vitest"

import { init } from "../../resources/js/select-all"
import { $, fire, html } from "./helpers"

const box = (selector: string) => $<HTMLInputElement>(selector)

const table = `
  <input type="checkbox" id="all" data-all="users">
  <input type="checkbox" id="all-resp" data-all="users">
  <input type="checkbox" id="r1" data-check="users" aria-label="އަލީ">
  <input type="checkbox" id="r2" data-check="users" aria-label="މުހައްމަދު">
  <input type="checkbox" id="r3" data-check="users" disabled>
  <input type="checkbox" id="other" data-check="posts">`

describe("select all", () => {
  it("checks and unchecks every enabled row", () => {
    html(table)
    init()

    box("#all").checked = true
    fire(box("#all"))

    expect(box("#r1").checked).toBe(true)
    expect(box("#r2").checked).toBe(true)
    expect(box("#r3").checked).toBe(false)
    expect(box("#other").checked).toBe(false)
    expect(box("#all-resp").checked).toBe(true)

    box("#all").checked = false
    fire(box("#all"))
    expect(box("#r1").checked).toBe(false)
  })

  it("is indeterminate when some rows are checked", () => {
    html(table)
    init()

    box("#r1").checked = true
    fire(box("#r1"))
    expect(box("#all").checked).toBe(false)
    expect(box("#all").indeterminate).toBe(true)

    box("#r2").checked = true
    fire(box("#r2"))
    expect(box("#all").checked).toBe(true)
    expect(box("#all").indeterminate).toBe(false)
  })

  it("syncs on init", () => {
    html(table.replace('id="r1"', 'id="r1" checked'))
    init()
    expect(box("#all").indeterminate).toBe(true)
  })

  it("ignores other changes", () => {
    html(`<input id="text"><input type="checkbox" id="plain">`)
    init()
    fire(box("#text"))
    fire(box("#plain"))
  })
})
