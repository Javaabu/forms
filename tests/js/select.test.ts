import { beforeEach, describe, expect, it, vi } from "vitest"

import {
  ajaxParams,
  enhance,
  init,
  instanceOf,
  loadChildren,
  refresh,
  reset,
  resolveUrl,
  setOptions,
  settingsFor,
} from "../../resources/js/select"
import { $, calledUrl, fire, flush, html, jsonResponse, mockFetch } from "./helpers"

const sel = (selector: string) => $<HTMLSelectElement>(selector)

const islands = [
  { id: 1, name: "މާލެ" },
  { id: 2, name: "ހުޅުމާލެ" },
]

describe("enhanced selects", () => {
  it("enhances select2 selects once, keeping the wrapper's own classes", () => {
    html(`
      <div data-slot="native-select-wrapper">
        <select id="s" class="h-8 w-full rounded-lg is-invalid select2-basic" data-placeholder="ރަށް" data-allow-clear="true">
          <option value="">ރަށް</option><option value="1" selected>މާލެ</option>
        </select>
      </div>
      <select id="plain"><option>x</option></select>`)

    init()
    init()

    const ts = instanceOf(sel("#s"))!
    expect(ts).toBeDefined()
    expect(instanceOf(sel("#plain"))).toBeUndefined()
    expect(ts.wrapper.classList.contains("h-8")).toBe(false)
    expect(ts.wrapper.classList.contains("is-invalid")).toBe(true)
    expect(ts.wrapper.classList.contains("select2-basic")).toBe(true)
    expect(ts.items).toEqual(["1"])
    expect(ts.settings.placeholder).toBe("ރަށް")
    expect(ts.settings.maxOptions).toBeNull()
    expect(document.querySelectorAll(".ts-wrapper")).toHaveLength(1)
    expect(enhance(sel("#s"))).toBe(ts)
  })

  it("titles the clear button in the page's language", () => {
    document.documentElement.setAttribute("lang", "dv")
    html(`<select id="s" class="select2-basic" data-allow-clear="true"><option value="1">1</option></select>`)
    const ts = enhance(sel("#s"))

    expect(ts.wrapper.querySelector(".clear-button")?.getAttribute("title")).toBe("ފޮހެލާ")
    expect(ts.render("no_results", {})?.textContent).toBe("އެއްވެސް ނަތީޖާއެއް ނުފެނުނު")
    expect(ts.render("loading", {})?.textContent).toBe("ލޯޑުވަނީ…")
  })

  it("hides the search box", () => {
    html(`<select id="s" class="select2-basic" data-minimum-results-for-search="Infinity" data-placeholder="ނަތީޖާ">
      <option value="">ނަތީޖާ</option><option value="1">1</option></select>`)
    const ts = enhance(sel("#s"))

    expect(ts.control.querySelector("input")).toBeNull()
    expect(ts.settings.allowEmptyOption).toBe(true)
  })

  it("lets users add tags", () => {
    html(`<select id="s" class="select2-basic" data-tags="true" multiple><option value="ހ">ހ</option></select>`)
    const ts = enhance(sel("#s"))

    expect(ts.settings.create).toBe(true)
    expect(ts.wrapper.classList.contains("plugin-remove_button")).toBe(true)
    expect(ts.render("option_create", { input: "<ދ>" })?.innerHTML).toBe('Add "&lt;ދ&gt;"')
  })

  it("renders icons", () => {
    html(`<select id="s" class="select2-b-icon" data-icon-prefix="fa" data-placeholder="އައިކަން">
      <option value="">-</option><option value="home" selected>ގެ</option></select>`)
    const ts = enhance(sel("#s"))

    expect(ts.wrapper.querySelector(".item i")?.className).toBe("fa fa-home select2-icon")
    expect(ts.render("option", { value: "", text: "-" })?.textContent).toBe("އައިކަން")
  })

  it("renders icons without a placeholder", () => {
    html(`<select id="s" class="select2-b-icon"><option value="">-</option></select>`)
    const ts = enhance(sel("#s"))
    expect(ts.render("option", { value: "", text: "-" })?.textContent).toBe("-")
  })

  it("puts the dropdown in the given parent, when it exists", () => {
    html(`<dialog id="m"><select id="s" class="select2-basic" data-dropdown-parent-elem="#m"></select>
      <select id="t" class="select2-basic" data-dropdown-parent-elem="#nope"></select></dialog>`)
    expect(enhance(sel("#s")).dropdown.parentElement).toBe($("#m"))
    expect(settingsFor(sel("#t")).dropdownParent).toBeUndefined()
  })

  it("follows the select's disabled state", async () => {
    html(`<select id="s" class="select2-basic"><option value="1">1</option></select>`)
    const ts = enhance(sel("#s"))

    sel("#s").disabled = true
    await flush()
    expect(ts.isDisabled).toBe(true)

    sel("#s").disabled = false
    await flush()
    expect(ts.isDisabled).toBe(false)
  })

  it("re-reads changed options", () => {
    html(`<select id="s" class="select2-basic"><option value="1" selected>1</option></select>`)
    const ts = enhance(sel("#s"))

    setOptions(
      sel("#s"),
      [
        { value: "3", text: "ތިން" },
        { value: "4", text: "ހަތަރެއް" },
      ],
      "4",
    )
    expect(Object.keys(ts.options)).toEqual(["3", "4"])
    expect(ts.items).toEqual(["4"])

    sel("#s").disabled = true
    refresh(sel("#s"))
    expect(ts.isDisabled).toBe(true)

    refresh(document.createElement("select"))
  })

  it("keeps an empty placeholder option when replacing options", () => {
    html(`<select id="s"><option value="">ނެތް</option><option value="1">1</option></select>
      <select id="m" multiple><option value="1">1</option></select>`)

    setOptions(sel("#s"), [{ value: "2", text: "ދެ" }])
    expect(sel("#s").options).toHaveLength(2)
    expect(sel("#s").value).toBe("")

    setOptions(
      sel("#m"),
      [
        { value: "2", text: "ދެ" },
        { value: "3", text: "ތިން" },
      ],
      ["2", "3"],
    )
    expect(Array.from(sel("#m").selectedOptions).map((o) => o.value)).toEqual(["2", "3"])
  })
})

/** Tom Select debounces loads by loadThrottle (250ms). */
async function settle(): Promise<void> {
  await vi.advanceTimersByTimeAsync(300)
}

describe("ajax selects", () => {
  beforeEach(() => {
    vi.useFakeTimers()
  })

  const ajax = (attrs = "") =>
    html(`<select id="s" class="select2-ajax" data-select-ajax-url="/api/islands" ${attrs}>
      <option value="9" selected>ތިނަދޫ</option></select>`)

  it("loads pages of results", async () => {
    ajax(`data-name-field="title" data-id-field="code" data-per-page="10"`)
    const fetch = mockFetch(
      jsonResponse({ data: [{ code: 1, title: "މާލެ" }], next_page_url: "/api/islands?page=2" }),
      jsonResponse({ data: [{ code: 2, title: "ހުޅުމާލެ" }], next_page_url: null }),
    )
    const ts = enhance(sel("#s"))

    ts.load("މާ")
    await settle()

    expect(calledUrl(fetch)).toBe(
      "/api/islands?append=&include=&page=1&fields=code,title&per_page=10&filter[search]=މާ",
    )
    expect(ts.options["1"]?.text).toBe("މާލެ")
    expect(ts.options["9"]?.text).toBe("ތިނަދޫ")

    ts.load("މާ")
    await settle()
    expect(calledUrl(fetch, 1)).toContain("page=2")
    expect(ts.options["2"]?.text).toBe("ހުޅުމާލެ")
  })

  it("reads plain arrays", async () => {
    ajax()
    mockFetch(jsonResponse(islands))
    const ts = enhance(sel("#s"))

    ts.load("ހ")
    await settle()
    expect(ts.options["2"]?.text).toBe("ހުޅުމާލެ")
  })

  it("shows an error when loading fails", async () => {
    document.documentElement.setAttribute("lang", "dv")
    ajax()
    mockFetch(new Error("offline"))
    const ts = enhance(sel("#s"))

    ts.load("ހ")
    await settle()
    expect(ts.render("no_results", {})?.textContent).toBe("އޮޕްޝަންތައް ލޯޑެއް ނުކުރެވުނު")
  })

  it("waits for the minimum input length", () => {
    ajax()
    const ts = enhance(sel("#s"))
    expect(ts.settings.shouldLoad("")).toBe(false)
    expect(ts.settings.shouldLoad("ހ")).toBe(true)
    expect(ts.settings.preload).toBe(false)
  })

  it("loads as soon as it opens with a minimum input length of 0", () => {
    ajax(`data-minimum-input-length="0"`)
    const settings = settingsFor(sel("#s"))
    expect(settings.preload).toBe("focus")
    expect((settings.shouldLoad as (q: string) => boolean)("")).toBe(true)

    sel("#s").setAttribute("data-minimum-input-length", "x")
    expect((settingsFor(sel("#s")).shouldLoad as (q: string) => boolean)("")).toBe(false)
  })

  it("scores every loaded result", () => {
    ajax()
    const settings = settingsFor(sel("#s")) as { score: () => () => number }
    expect(settings.score()()).toBe(1)
  })

  it("does nothing without a URL", async () => {
    html(`<select id="s" class="select2-ajax"></select>`)
    const fetch = mockFetch()
    enhance(sel("#s")).load("ހ")
    await settle()
    expect(fetch).not.toHaveBeenCalled()
  })

  it("picks the URL for data-selected-url", () => {
    html(
      `<select id="s" class="select2-ajax" data-select-ajax-url='{"island":"/api/islands","atoll":"/api/atolls"}' data-selected-url="atoll"></select>`,
    )
    expect(resolveUrl(sel("#s"))).toBe("/api/atolls")

    sel("#s").setAttribute("data-selected-url", "nope")
    expect(resolveUrl(sel("#s"))).toBe("/api/islands")

    sel("#s").setAttribute("data-select-ajax-url", "{}")
    expect(resolveUrl(sel("#s"))).toBe("")

    sel("#s").setAttribute("data-select-ajax-url", "[1]")
    expect(resolveUrl(sel("#s"))).toBe("")
  })

  it("filters by a parent select", () => {
    html(`
      <select id="atoll"><option value="">-</option><option value="k" selected>ކ</option></select>
      <select id="s" class="select2-ajax" data-select-ajax-url="/api/atolls/:value/islands" data-select-parent="#atoll" data-filter-field="atoll"></select>`)

    expect(resolveUrl(sel("#s"))).toBe("/api/atolls/k/islands")
    expect(ajaxParams(sel("#s"), 1, "")).toEqual({
      append: "",
      include: "",
      page: 1,
      fields: "id,name",
      filter: { atoll: "k" },
    })
  })

  it("is disabled until the parent has a value, and resets when it changes", async () => {
    html(`
      <select id="atoll"><option value="" selected>-</option><option value="k">ކ</option><option value="b">ބ</option></select>
      <select id="s" class="select2-ajax" data-select-ajax-url="/api/:value" data-filter-parent="#atoll"><option value="1" selected>1</option></select>
      <select id="other" class="select2-ajax" data-select-ajax-url="/api" data-filter-parent="#nope"></select>`)

    init()
    expect(sel("#s").disabled).toBe(true)
    const changed = vi.fn()
    sel("#s").addEventListener("change", changed)

    sel("#atoll").value = "k"
    fire(sel("#atoll"))
    await flush()
    expect(sel("#s").disabled).toBe(false)
    expect(sel("#s").options).toHaveLength(0)
    expect(instanceOf(sel("#s"))!.isDisabled).toBe(false)
    expect(changed).toHaveBeenCalledOnce()

    fire(sel("#atoll"))
    expect(changed).toHaveBeenCalledOnce()

    sel("#atoll").value = ""
    fire(sel("#atoll"))
    expect(sel("#s").disabled).toBe(true)
  })

  it("resets plain selects too", () => {
    html(`<select id="s"><option value="1">1</option></select>`)
    reset(sel("#s"))
    expect(sel("#s").options).toHaveLength(0)
  })
})

describe("cascades", () => {
  const cascade = (childAttrs = "", parentAttrs = "") =>
    html(`
      <select id="atoll" data-select-child="#island" ${parentAttrs}>
        <option value="">-</option><option value="k" selected>ކ</option>
      </select>
      <select id="island" data-select-ajax-url="/api/atolls/:value/islands" data-filter-field="atoll" ${childAttrs}>
        <option value="2" selected>ހުޅުމާލެ</option>
      </select>
      <input id="fallback" hidden disabled>`)

  it("loads the child's options for data-first and keeps its value", async () => {
    cascade("", "data-first")
    const fetch = mockFetch(jsonResponse(islands))

    init()
    expect(sel("#island").disabled).toBe(true)
    expect(sel("#island").options[0]?.textContent).toBe("Loading...")

    await flush()
    expect(calledUrl(fetch)).toBe("/api/atolls/k/islands?fields=id,name&per_page=-1&include=&append=&filter[atoll]=k")
    expect(Array.from(sel("#island").options).map((o) => o.textContent)).toEqual(["މާލެ", "ހުޅުމާލެ"])
    expect(sel("#island").value).toBe("2")
    expect(sel("#island").disabled).toBe(false)
  })

  it("keeps the child's placeholder across loads", async () => {
    cascade()
    sel("#island").insertAdjacentHTML("afterbegin", `<option value="">ރަށެއް</option>`)
    mockFetch(jsonResponse(islands))

    await loadChildren(sel("#atoll"))
    expect(Array.from(sel("#island").options).map((o) => o.textContent)).toEqual(["ރަށެއް", "މާލެ", "ހުޅުމާލެ"])
  })

  it("doesn't auto-load with .no-auto-trigger", () => {
    cascade("", 'data-first class="no-auto-trigger"')
    const fetch = mockFetch()
    init()
    expect(fetch).not.toHaveBeenCalled()
  })

  it("loads on change, into an enhanced child", async () => {
    cascade('class="select2-basic"')
    mockFetch(jsonResponse({ data: islands }))
    init()

    fire(sel("#atoll"))
    await flush()
    expect(Object.keys(instanceOf(sel("#island"))!.options)).toEqual(["1", "2"])
  })

  it("shows the error text when loading fails", async () => {
    document.documentElement.setAttribute("lang", "dv")
    cascade()
    mockFetch(jsonResponse({}, 500))

    await loadChildren(sel("#atoll"))
    expect(sel("#island").options[0]?.textContent).toBe("އޮޕްޝަންތައް ލޯޑެއް ނުކުރެވުނު")
  })

  it("swaps in the fallback when there are no options", async () => {
    cascade('data-fallback="#fallback"')
    mockFetch(jsonResponse([]), jsonResponse(islands))

    await loadChildren(sel("#atoll"))
    expect(sel("#island").hidden).toBe(true)
    expect(sel("#island").disabled).toBe(true)
    expect($<HTMLInputElement>("#fallback").hidden).toBe(false)
    expect($<HTMLInputElement>("#fallback").disabled).toBe(false)

    await loadChildren(sel("#atoll"))
    expect(sel("#island").hidden).toBe(false)
    expect($<HTMLInputElement>("#fallback").hidden).toBe(true)
    expect($<HTMLInputElement>("#fallback").disabled).toBe(true)
  })

  it("disables an empty child with data-disable-child", async () => {
    cascade("", 'data-disable-child="true"')
    mockFetch(jsonResponse([]))
    await loadChildren(sel("#atoll"))
    expect(sel("#island").disabled).toBe(true)
  })

  it("empties and disables the child when the parent is cleared", async () => {
    cascade('data-fallback="#fallback"', 'data-fallback="#parent-fallback"')
    document.body.insertAdjacentHTML("beforeend", `<input id="parent-fallback">`)
    sel("#atoll").value = ""
    const changed = vi.fn()
    sel("#island").addEventListener("change", changed)

    await loadChildren(sel("#atoll"))
    expect(sel("#island").options).toHaveLength(0)
    expect(sel("#island").disabled).toBe(true)
    expect($<HTMLInputElement>("#fallback").hidden).toBe(false)
    expect($<HTMLInputElement>("#fallback").disabled).toBe(false)
    expect(changed).toHaveBeenCalledOnce()
  })

  it("disables the fallback when the parent's fallback is disabled", async () => {
    cascade('data-fallback="#fallback"')
    sel("#atoll").value = ""
    await loadChildren(sel("#atoll"))
    expect($<HTMLInputElement>("#fallback").disabled).toBe(true)
  })

  it("ignores a response that a newer request replaced", async () => {
    cascade()
    let release: (r: Response) => void = () => undefined
    mockFetch(() => new Promise<Response>((resolve) => (release = resolve)), jsonResponse([{ id: 5, name: "ދ" }]))

    const first = loadChildren(sel("#atoll"))
    await flush()
    await loadChildren(sel("#atoll"))
    release(jsonResponse(islands))
    await first

    expect(Array.from(sel("#island").options).map((o) => o.value)).toEqual(["5"])
  })

  it("points an ajax child at the URL for the value", async () => {
    html(`
      <select id="type" data-ajax-child="#target"><option value="">-</option><option value="island" selected>ރަށް</option><option value="atoll">އަތޮޅު</option></select>
      <select id="target" class="select2-ajax" data-select-ajax-url='{"island":"/api/islands","atoll":"/api/atolls"}' data-selected-url="island">
        <option value="1" selected>މާލެ</option></select>`)

    init()
    expect(sel("#target").disabled).toBe(false)
    expect(sel("#target").value).toBe("1")

    sel("#type").value = "atoll"
    fire(sel("#type"))
    expect(sel("#target").getAttribute("data-selected-url")).toBe("atoll")
    expect(sel("#target").options).toHaveLength(0)
    expect(resolveUrl(sel("#target"))).toBe("/api/atolls")

    sel("#type").value = ""
    fire(sel("#type"))
    expect(sel("#target").disabled).toBe(true)
    expect(sel("#target").hasAttribute("data-selected-url")).toBe(false)
    await flush()
    expect(instanceOf(sel("#target"))!.isDisabled).toBe(true)
  })

  it("handles multiple parents", async () => {
    html(`
      <select id="p" multiple data-select-child="#c" data-ajax-child="#a">
        <option value="1" selected>1</option><option value="2" selected>2</option></select>
      <select id="c" data-select-ajax-url="/api/:value"></select>
      <select id="a"></select>`)
    const fetch = mockFetch(jsonResponse([]))
    await loadChildren(sel("#p"))
    expect(calledUrl(fetch)).toContain("/api/1,2")

    init()
    expect(sel("#a").getAttribute("data-selected-url")).toBe("1,2")
  })

  it("ignores change events from non-elements", () => {
    init()
    document.dispatchEvent(new Event("change"))
  })
})
