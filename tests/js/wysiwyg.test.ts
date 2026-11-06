import { describe, expect, it, vi } from "vitest"

import { init, settingsFor } from "../../resources/js/wysiwyg"
import { $, html } from "./helpers"

describe("wysiwyg", () => {
  it("does nothing without TinyMCE", () => {
    html(`<textarea class="wysiwyg" id="t"></textarea>`)
    init()
    expect($("#t").hasAttribute("data-forms-ready")).toBe(false)
  })

  it("initialises TinyMCE once per textarea with the package's settings", () => {
    const tinymce = { init: vi.fn() }
    vi.stubGlobal("tinymce", tinymce)
    html(`<textarea class="wysiwyg" id="t">ލިޔުން</textarea><textarea id="plain"></textarea>`)

    init()
    init()

    expect(tinymce.init).toHaveBeenCalledOnce()
    expect(tinymce.init).toHaveBeenCalledWith(
      expect.objectContaining({
        target: $("#t"),
        menubar: false,
        plugins: ["autolink", "link", "lists", "directionality", "code", "visualchars", "quickbars"],
        quickbars_insert_toolbar: false,
        directionality: "ltr",
      }),
    )
  })

  it("follows the textarea's or the page's direction", () => {
    html(`<textarea class="wysiwyg" id="a" dir="rtl"></textarea><textarea class="wysiwyg" id="b"></textarea>`)
    expect(settingsFor($("#a")).directionality).toBe("rtl")
    expect(settingsFor($("#b")).directionality).toBe("ltr")

    document.documentElement.setAttribute("dir", "rtl")
    expect(settingsFor($("#b")).directionality).toBe("rtl")
    expect(String((settingsFor($("#b")).toolbar as string[])[0])).toContain("ltr rtl")
  })

  it("picks up TinyMCE loaded later, on window load", () => {
    const tinymce = { init: vi.fn() }
    html(`<textarea class="wysiwyg" id="t"></textarea>`)
    vi.stubGlobal("tinymce", tinymce)
    window.dispatchEvent(new Event("load"))
    expect(tinymce.init).not.toHaveBeenCalled()
  })
})
