import { describe, expect, it } from "vitest"

import { getJson, itemsOf, toOptions, withQuery } from "../../resources/js/remote"
import { jsonResponse, mockFetch } from "./helpers"

describe("remote", () => {
  it("builds query strings like jQuery's $.param()", () => {
    const url = withQuery("/api/islands", {
      append: "",
      page: 2,
      filter: { search: "މާލެ", atoll: ["1", "2"] },
      none: null,
    })

    expect(decodeURIComponent(url)).toBe(
      "/api/islands?append=&page=2&filter[search]=މާލެ&filter[atoll][]=1&filter[atoll][]=2&none=",
    )
    expect(withQuery("/api?x=1", { y: 2 })).toBe("/api?x=1&y=2")
    expect(withQuery("/api", {})).toBe("/api")
  })

  it("reads plain arrays and paginated responses", () => {
    expect(itemsOf([{ id: 1 }])).toEqual({ items: [{ id: 1 }], more: false })
    expect(itemsOf({ data: [{ id: 1 }], next_page_url: "/?page=2" })).toEqual({ items: [{ id: 1 }], more: true })
    expect(itemsOf({ data: [], next_page_url: null })).toEqual({ items: [], more: false })
    expect(itemsOf({ nope: true })).toEqual({ items: [], more: false })
    expect(itemsOf("x")).toEqual({ items: [], more: false })
  })

  it("maps items to options", () => {
    expect(toOptions([{ code: 7, title: "ހުޅުމާލެ" }, {}], "code", "title")).toEqual([
      { value: "7", text: "ހުޅުމާލެ" },
      { value: "", text: "" },
    ])
  })

  it("gets JSON with Laravel's ajax headers", async () => {
    const fetch = mockFetch(jsonResponse([{ id: 1 }]), jsonResponse({}, 500))

    await expect(getJson("/api")).resolves.toEqual([{ id: 1 }])
    expect(fetch).toHaveBeenCalledWith("/api", {
      headers: { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" },
      credentials: "same-origin",
      signal: undefined,
    })

    await expect(getJson("/api")).rejects.toThrow("HTTP 500")
  })
})
