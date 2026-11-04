/**
 * Loads the package's strings (generated from lang/ by `pnpm locales`) under the
 * `forms::strings` group, so modules can call `__("forms::strings.loading")`.
 * The active locale comes from `<html lang>`.
 */
import { __, load, type Replacements } from "./i18n"
import dv from "./locales/dv.json"
import en from "./locales/en.json"

load({ "forms::strings": en }, { locale: "en" })
load({ "forms::strings": dv }, { locale: "dv" })

export { __ }
export type { Replacements }
