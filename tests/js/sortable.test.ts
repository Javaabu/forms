import { afterEach, beforeEach, describe, expect, it, vi } from "vitest"

import { init, sort } from "../../resources/js/sortable"
import { $, click, html, key } from "./helpers"

const page = (form = `<input type="hidden" name="orderby"><input type="hidden" name="order">`) => `
  <form id="filter">${form}</form>
  <table data-form-sortable="#filter">
    <thead><tr>
      <th id="name" class="sorting" data-sort-field="name">ނަން</th>
      <th id="date" class="sorting_asc" data-sort-field="created_at">ތާރީޚު</th>
      <th id="plain">ބާވަތް</th>
      <th id="check" class="sorting" data-sort-field="id"><input type="checkbox" id="all"></th>
    </tr></thead>
  </table>`

const value = (name: string) => $<HTMLFormElement>("#filter").querySelector<HTMLInputElement>(`[name="${name}"]`)?.value

describe("sortable tables", () => {
  let submit: ReturnType<typeof vi.fn>

  beforeEach(() => {
    submit = vi.fn()
    HTMLFormElement.prototype.requestSubmit = submit as unknown as HTMLFormElement["requestSubmit"]
  })

  afterEach(() => {
    delete (HTMLFormElement.prototype as Partial<HTMLFormElement>).requestSubmit
  })

  it("sorts ascending by a new field and submits the form", () => {
    html(page())
    init()

    expect(click($("#name")).defaultPrevented).toBe(true)
    expect(value("orderby")).toBe("name")
    expect(value("order")).toBe("ASC")
    expect(submit).toHaveBeenCalledOnce()

    expect($("#name").className).toBe("sorting_asc")
    expect($("#name").getAttribute("aria-sort")).toBe("ascending")
    expect($("#date").className).toBe("sorting")
    expect($("#date").getAttribute("aria-sort")).toBe("none")
  })

  it("toggles an ascending field to descending", () => {
    html(page())
    init()

    click($("#date"))
    expect(value("orderby")).toBe("created_at")
    expect(value("order")).toBe("DESC")
    expect($("#date").className).toBe("sorting_desc")
    expect($("#date").getAttribute("aria-sort")).toBe("descending")

    click($("#date"))
    expect(value("order")).toBe("ASC")
  })

  it("adds the hidden inputs the form is missing", () => {
    html(page(""))
    init()
    click($("#name"))
    expect(value("orderby")).toBe("name")
    expect(value("order")).toBe("ASC")
    expect($("#filter").querySelectorAll('input[type="hidden"]')).toHaveLength(2)
  })

  it("makes headings focusable and sorts with the keyboard", () => {
    html(page())
    init()
    init()

    expect($("#name").tabIndex).toBe(0)
    expect($("#name").getAttribute("aria-sort")).toBe("none")
    expect($("#date").getAttribute("aria-sort")).toBe("ascending")
    expect($("#plain").hasAttribute("tabindex")).toBe(false)

    expect(key($("#name"), "Enter").defaultPrevented).toBe(true)
    expect(value("orderby")).toBe("name")
    key($("#date"), " ")
    expect(value("orderby")).toBe("created_at")
    expect(key($("#name"), "a").defaultPrevented).toBe(false)
    expect(key($("#plain"), "Enter").defaultPrevented).toBe(false)
    expect(submit).toHaveBeenCalledTimes(2)
  })

  it("reads sorting_desc headings", () => {
    html(page().replace('class="sorting_asc"', 'class="sorting_desc"'))
    init()
    expect($("#date").getAttribute("aria-sort")).toBe("descending")
    click($("#date"))
    expect(value("order")).toBe("ASC")
  })

  it("leaves controls inside headings and other clicks alone", () => {
    html(page())
    init()
    click($("#all"))
    click($("#plain"))
    document.dispatchEvent(new MouseEvent("click", { bubbles: true }))
    document.dispatchEvent(new KeyboardEvent("keydown", { key: "Enter" }))
    expect(submit).not.toHaveBeenCalled()
  })

  it("does nothing without the form", () => {
    html(page().replace('data-form-sortable="#filter"', 'data-form-sortable="#nope"'))
    init()
    click($("#name"))
    expect(submit).not.toHaveBeenCalled()

    html(`<table data-form-sortable><tr><th id="x" data-sort-field="a"></th></tr></table>`)
    sort($("#x"))
    expect(submit).not.toHaveBeenCalled()
  })

  it("falls back to submit() without requestSubmit", () => {
    delete (HTMLFormElement.prototype as Partial<HTMLFormElement>).requestSubmit
    html(page())
    const native = vi.spyOn(HTMLFormElement.prototype, "submit").mockImplementation(() => undefined)
    sort($("#name"))
    expect(native).toHaveBeenCalledOnce()
  })
})
