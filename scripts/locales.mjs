// Writes resources/js/locales/{locale}.json from lang/{locale}/strings.php, so the
// browser modules show the same strings as the Blade views. Run with `pnpm locales`
// after changing lang/; CI fails when the JSON is out of date.
import { execFileSync } from "node:child_process"
import { readdirSync, writeFileSync } from "node:fs"

const LANG = "lang"
const OUT = "resources/js/locales"

const locales = readdirSync(LANG, { withFileTypes: true })
  .filter((entry) => entry.isDirectory())
  .map((entry) => entry.name)
  .sort()

for (const locale of locales) {
  const file = `${LANG}/${locale}/strings.php`
  const json = execFileSync(
    "php",
    [
      "-r",
      "echo json_encode(require $argv[1], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);",
      file,
    ],
    { encoding: "utf8" },
  )
  const strings = JSON.parse(json)
  const sorted = Object.fromEntries(
    Object.keys(strings)
      .sort()
      .map((key) => [key, strings[key]]),
  )

  writeFileSync(`${OUT}/${locale}.json`, JSON.stringify(sorted, null, 2) + "\n")
  console.log(`${OUT}/${locale}.json: ${Object.keys(sorted).length} strings`)
}
