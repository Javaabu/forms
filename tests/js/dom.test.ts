import { describe, expect, it, vi } from "vitest"

import {
  all,
  autoInit,
  currentValue,
  data,
  escapeHtml,
  flag,
  isBlank,
  isRtl,
  once,
  onReady,
  picks,
  select,
  valueOf,
} from "../../resources/js/dom"
import { $, flush, html } from "./helpers"

describe("dom helpers", () => {
  it("marks elements once per feature", () => {
    html(`<div id="a"></div>`)
    const el = $("#a")

    expect(once(el, "select")).toBe(true)
    expect(once(el, "select")).toBe(false)
    expect(once(el, "dates")).toBe(true)
    expect(el.getAttribute("data-forms-ready")).toBe("select dates")
  })

  it("finds elements including the root", () => {
    html(`<div class="x" id="root"><span class="x"></span></div>`)
    expect(all($("#root"), ".x")).toHaveLength(2)
    expect(all(document, ".x")).toHaveLength(2)
  })

  it("ignores invalid selectors", () => {
    expect(select("[[[")).toEqual([])
    expect(select("")).toEqual([])
    expect(picks("[[[", document.body)).toBe(false)
    expect(picks(null, document.body)).toBe(false)
    expect(picks("body", document.body)).toBe(true)
  })

  it("reads data attributes like jQuery", () => {
    html(
      `<div id="a" data-t="true" data-f="false" data-n="12" data-null="null" data-j='["1","2"]' data-o='{"a":1}' data-bad="[oops" data-s="ދިވެހި" data-e=""></div>`,
    )
    const el = $("#a")

    expect(data(el, "t")).toBe(true)
    expect(data(el, "f")).toBe(false)
    expect(data(el, "n")).toBe(12)
    expect(data(el, "null")).toBeNull()
    expect(data(el, "j")).toEqual(["1", "2"])
    expect(data(el, "o")).toEqual({ a: 1 })
    expect(data(el, "bad")).toBe("[oops")
    expect(data(el, "s")).toBe("ދިވެހި")
    expect(data(el, "missing")).toBeUndefined()
    expect(flag(el, "e")).toBe(false)
    expect(flag(el, "t")).toBe(true)
  })

  it("escapes html", () => {
    expect(escapeHtml(`<a href="x">'&'</a>`)).toBe("&lt;a href=&quot;x&quot;&gt;&#039;&amp;&#039;&lt;/a&gt;")
    expect(escapeHtml(null)).toBe("")
  })

  it("knows the direction", () => {
    html(`<div dir="rtl"><input id="a"></div><input id="b">`)
    expect(isRtl($("#a"))).toBe(true)
    expect(isRtl($("#b"))).toBe(false)
    expect(isRtl()).toBe(false)
  })

  it("reads values", () => {
    html(`
      <select id="m" multiple><option value="1" selected> އެއް</option><option value="2" selected>ދެ</option></select>
      <input type="radio" name="r" value="a"><input type="radio" name="r" value="b" checked>
      <input type="checkbox" name="c" value="x" checked><input type="checkbox" name="c" value="y">
      <input id="t" value="ހ">
      <div id="d"></div>`)

    expect(valueOf($("#m"))).toEqual(["1", "2"])
    expect(valueOf($("#t"))).toBe("ހ")
    expect(valueOf($("#d"))).toBe("")
    expect(currentValue(select("[name=r]"))).toBe("b")
    expect(currentValue(select("[name=c]"))).toEqual(["x"])
    expect(currentValue(select("#t"))).toBe("ހ")
    expect(isBlank([])).toBe(true)
    expect(isBlank("")).toBe(true)
    expect(isBlank("0")).toBe(false)
  })

  it("runs when the DOM is ready", () => {
    const fn = vi.fn()
    onReady(fn)
    expect(fn).toHaveBeenCalledOnce()

    const state = vi.spyOn(document, "readyState", "get").mockReturnValue("loading")
    const later = vi.fn()
    onReady(later)
    expect(later).not.toHaveBeenCalled()
    state.mockRestore()
    document.dispatchEvent(new Event("DOMContentLoaded"))
    expect(later).toHaveBeenCalledOnce()
  })

  it("initialises on load and again for added content", async () => {
    document.documentElement.removeAttribute("data-forms-manual")
    const init = vi.fn()

    autoInit(init, 0)
    expect(init).toHaveBeenCalledTimes(1)

    document.body.appendChild(document.createTextNode("ނޯޑު"))
    await flush()
    expect(init).toHaveBeenCalledTimes(1)

    document.body.appendChild(document.createElement("div"))
    await flush()
    expect(init).toHaveBeenCalledTimes(2)

    document.documentElement.setAttribute("data-forms-manual", "")
  })

  it("does nothing in manual mode", () => {
    const init = vi.fn()
    autoInit(init)
    expect(init).not.toHaveBeenCalled()
  })
})
