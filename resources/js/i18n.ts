/**
 * TEMPORARY stand-in for @javaabu/i18n.
 *
 * @javaabu/i18n isn't published to npm yet, and installing it from GitHub gives a
 * package without its dist/ (the repo has no `prepare` script). This file has the
 * same signatures for the parts we use (`__`, `load`, `addLines`, `getLocale`,
 * `setLocale`), so switching is a one-line change in ./lang.ts once it is
 * published: `import { __, load } from "@javaabu/i18n"`.
 */

export type Replacements = Record<string, string | number>

type Lines = Record<string, Record<string, Record<string, string>>>

const lines: Lines = {}
let localeOverride: string | undefined
let fallback = "en"

/** `en-GB` → `en_GB`, `DV` → `dv`. */
export function normalizeLocale(locale: string): string {
  const [language = "", ...rest] = locale.trim().replace(/-/g, "_").split("_")

  return [language.toLowerCase(), ...rest.map((part) => part.toUpperCase())].join("_")
}

/** The locale from `<html lang>`, like Laravel's `App::getLocale()`. */
export function getLocale(): string {
  if (localeOverride) return localeOverride

  const lang = typeof document === "undefined" ? "" : document.documentElement.getAttribute("lang")

  return lang ? normalizeLocale(lang) : fallback
}

export function setLocale(locale: string | undefined): void {
  localeOverride = locale ? normalizeLocale(locale) : undefined
}

export function getFallback(): string {
  return fallback
}

export function setFallback(locale: string): void {
  fallback = normalizeLocale(locale)
}

/** Adds lines shaped like `{ "forms::strings": { loading: "Loading..." } }`. */
export function load(messages: Record<string, Record<string, string>>, options: { locale: string }): void {
  const locale = normalizeLocale(options.locale)
  const target = (lines[locale] ??= {})

  for (const [group, items] of Object.entries(messages)) {
    target[group] = { ...target[group], ...items }
  }
}

/** `Lang::addLines()`: `{ "strings.loading": "Loading..." }`. */
export function addLines(items: Record<string, string>, locale: string, namespace = "*"): void {
  for (const [key, value] of Object.entries(items)) {
    const dot = key.indexOf(".")
    if (dot < 1) continue

    const group = key.slice(0, dot)
    load({ [namespace === "*" ? group : `${namespace}::${group}`]: { [key.slice(dot + 1)]: value } }, { locale })
  }
}

function find(key: string, locale: string): string | undefined {
  const separator = key.indexOf("::")
  const dot = key.indexOf(".", separator < 0 ? 0 : separator + 2)
  if (dot < 0) return undefined

  const group = key.slice(0, dot)
  const item = key.slice(dot + 1)
  const candidates = [locale, locale.split("_")[0] as string, fallback]

  for (const candidate of candidates) {
    const line = lines[candidate]?.[group]?.[item]
    if (line !== undefined) return line
  }

  return undefined
}

function upperFirst(value: string): string {
  return value.charAt(0).toUpperCase() + value.slice(1)
}

/** Laravel's `makeReplacements()`: `:name`, `:Name` and `:NAME`, longest placeholder first. */
export function makeReplacements(line: string, replace: Replacements = {}): string {
  const pairs: [string, string][] = []

  for (const [key, raw] of Object.entries(replace)) {
    const value = String(raw)
    pairs.push([`:${upperFirst(key)}`, upperFirst(value)], [`:${key.toUpperCase()}`, value.toUpperCase()])
    pairs.push([`:${key}`, value])
  }

  if (!pairs.length) return line

  pairs.sort((a, b) => b[0].length - a[0].length)

  let out = ""
  let index = 0

  outer: while (index < line.length) {
    for (const [search, value] of pairs) {
      if (line.startsWith(search, index)) {
        out += value
        index += search.length
        continue outer
      }
    }
    out += line[index]
    index++
  }

  return out
}

/** Laravel's `__()`: the line for the key, or the key itself when there's none. */
export function __(key: string, replace: Replacements = {}, locale?: string): string {
  const line = find(key, locale ? normalizeLocale(locale) : getLocale()) ?? key

  return makeReplacements(line, replace)
}

export const trans = __
