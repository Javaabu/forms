import { describe, expect, it, vi } from "vitest"

import { clearDate, init, resize, round } from "../../resources/js/inputs"
import { $, click, fire, html } from "./helpers"

describe("auto resize", () => {
  it("grows with the content", () => {
    html(`<textarea id="t" data-auto-resize="true" style="box-sizing: border-box; border: 2px solid"></textarea>`)
    const textarea = $<HTMLTextAreaElement>("#t")
    Object.defineProperty(textarea, "scrollHeight", { configurable: true, get: () => 80 })

    init()
    expect(textarea.style.height).toBe("84px")
    expect(textarea.style.overflowY).toBe("hidden")

    Object.defineProperty(textarea, "scrollHeight", { configurable: true, get: () => 120 })
    textarea.value = "ދިގު ލިޔުމެއް\nދެވަނަ ލައިން"
    fire(textarea, "input")
    expect(textarea.style.height).toBe("124px")
  })

  it("leaves out the padding for content-box textareas", () => {
    html(`<textarea id="t" style="padding: 5px"></textarea>`)
    const textarea = $<HTMLTextAreaElement>("#t")
    Object.defineProperty(textarea, "scrollHeight", { configurable: true, get: () => 50 })

    resize(textarea)
    expect(textarea.style.height).toBe("40px")
  })

  it("ignores other textareas", () => {
    html(`<textarea id="t"></textarea>`)
    init()
    fire($("#t"), "input")
    expect($("#t").style.height).toBe("")
  })
})

describe("decimals", () => {
  it("rounds on change and blur", () => {
    html(`<input id="n" type="number" data-decimals="2"><input id="z" data-decimals="0">`)
    init()

    const input = $<HTMLInputElement>("#n")
    input.value = "3.14159"
    fire(input)
    expect(input.value).toBe("3.14")

    input.value = "2"
    fire(input, "focusout")
    expect(input.value).toBe("2.00")

    $<HTMLInputElement>("#z").value = "2.5"
    fire($("#z"))
    expect($<HTMLInputElement>("#z").value).toBe("3")
  })

  it("leaves empty, invalid and unconfigured values alone", () => {
    html(`<input id="a" data-decimals="2"><input id="b" data-decimals="x"><input id="c" data-decimals="2">`)
    const a = $<HTMLInputElement>("#a")
    const b = $<HTMLInputElement>("#b")
    const c = $<HTMLInputElement>("#c")
    b.value = "1.234"
    c.value = "ދިވެހި"

    round(a)
    round(b)
    round(c)
    expect([a.value, b.value, c.value]).toEqual(["", "1.234", "ދިވެހި"])
  })
})

describe("date clear", () => {
  it("clears the input and fires change", () => {
    html(`<input id="d" value="2024-01-02"><button id="x" data-date-clear="#d">ފޮހެލާ</button>`)
    init()
    const change = vi.fn()
    $("#d").addEventListener("change", change)

    expect(click($("#x")).defaultPrevented).toBe(true)
    expect($<HTMLInputElement>("#d").value).toBe("")
    expect(change).toHaveBeenCalledOnce()
  })

  it("clears through flatpickr when there is one", () => {
    html(`<input id="d" value="2024-01-02"><button id="x" data-date-clear="#d"><span id="icon"></span></button>`)
    init()
    const clear = vi.fn()
    Object.assign($("#d"), { _flatpickr: { clear } })

    click($("#icon"))
    expect(clear).toHaveBeenCalledWith(true)
  })

  it("skips disabled inputs and bad targets", () => {
    html(`<input id="d" value="2024-01-02" disabled><button id="x" data-date-clear="#d"></button>
      <button id="y" data-date-clear="[["></button><button id="z" data-date-clear="#x"></button>`)
    init()
    click($("#x"))
    click($("#y"))
    click($("#z"))
    expect($<HTMLInputElement>("#d").value).toBe("2024-01-02")

    const input = document.createElement("input")
    input.readOnly = true
    input.value = "x"
    clearDate(input)
    expect(input.value).toBe("x")
  })
})
