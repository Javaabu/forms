import { describe, expect, it } from "vitest"

import {
  __,
  addLines,
  getFallback,
  getLocale,
  load,
  makeReplacements,
  normalizeLocale,
  setFallback,
  setLocale,
  trans,
} from "../../resources/js/i18n"
import "../../resources/js/lang"

describe("i18n", () => {
  it("reads the locale from <html lang>", () => {
    document.documentElement.setAttribute("lang", "dv-MV")
    expect(getLocale()).toBe("dv_MV")

    document.documentElement.removeAttribute("lang")
    expect(getLocale()).toBe("en")
  })

  it("normalizes locales", () => {
    expect(normalizeLocale("EN-gb")).toBe("en_GB")
    expect(normalizeLocale("dv")).toBe("dv")
  })

  it("translates the package's strings in the page's locale", () => {
    document.documentElement.setAttribute("lang", "dv")
    expect(__("forms::strings.loading")).toBe("ލޯޑުވަނީ…")

    document.documentElement.setAttribute("lang", "en")
    expect(__("forms::strings.loading")).toBe("Loading...")
  })

  it("falls back from a regional locale to its language and then to the fallback", () => {
    document.documentElement.setAttribute("lang", "dv-MV")
    expect(__("forms::strings.clear")).toBe("ފޮހެލާ")

    document.documentElement.setAttribute("lang", "fr")
    expect(__("forms::strings.clear")).toBe("Clear")
  })

  it("takes an explicit locale", () => {
    expect(__("forms::strings.close", {}, "dv")).toBe("ބަންދުކުރޭ")
  })

  it("returns the key for a missing line", () => {
    expect(__("forms::strings.missing")).toBe("forms::strings.missing")
    expect(__("nogroup")).toBe("nogroup")
  })

  it("makes Laravel's replacements", () => {
    expect(__("forms::strings.file_too_large", { size: 2 })).toBe("File size cannot be greater than 2 MB")
    expect(makeReplacements(":name, :Name, :NAME", { name: "ali" })).toBe("ali, Ali, ALI")
    expect(makeReplacements(":a :ab", { a: "1", ab: "2" })).toBe("1 2")
    expect(makeReplacements("no placeholders")).toBe("no placeholders")
  })

  it("adds lines like Lang::addLines()", () => {
    addLines({ "messages.hello": "ހެލޯ :name", invalid: "x" }, "dv")
    addLines({ "strings.extra": "އިތުރު" }, "dv", "forms")

    expect(__("messages.hello", { name: "އަލީ" }, "dv")).toBe("ހެލޯ އަލީ")
    expect(__("forms::strings.extra", {}, "dv")).toBe("އިތުރު")
    expect(trans("forms::strings.extra", {}, "dv")).toBe("އިތުރު")
  })

  it("loads groups and overrides the locale and fallback", () => {
    load({ "app::labels": { name: "ނަން" } }, { locale: "DV" })
    setLocale("dv")
    expect(__("app::labels.name")).toBe("ނަން")
    setLocale(undefined)

    setFallback("dv")
    expect(getFallback()).toBe("dv")
    document.documentElement.setAttribute("lang", "fr")
    expect(__("app::labels.name")).toBe("ނަން")
    setFallback("en")
  })
})
