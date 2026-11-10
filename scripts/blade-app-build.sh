#!/usr/bin/env bash
# Builds javaabu/forms' Blade scripts and styles in an empty app that installs only the
# npm packages forms declares for manifest's "assets" scope (scripts/npm-requirements.php),
# as `php artisan manifest:check` would ask a Blade-only app to. Peers aren't installed
# automatically, so an undeclared import (even one inside a dependency) fails the build.
#
# Usage: scripts/blade-app-build.sh  (needs PHP with Composer deps, Node and npm)
set -euo pipefail

root="$(cd "$(dirname "$0")/.." && pwd)"
app="$(mktemp -d)"
trap 'rm -rf "$app"' EXIT

requirements=()
while IFS= read -r line; do requirements+=("$line"); done < <(php "$root/scripts/npm-requirements.php")
echo "Installing: ${requirements[*]}"

cp -R "$root/resources/js" "$root/resources/css" "$app/"
cat > "$app/package.json" <<'JSON'
{ "name": "blade-app", "private": true, "type": "module" }
JSON
cat > "$app/vite.config.js" <<'JS'
import { defineConfig } from "vite"
import tailwindcss from "@tailwindcss/vite"

const here = (path) => new URL(path, import.meta.url).pathname

export default defineConfig({
  plugins: [tailwindcss()],
  resolve: { alias: { "@javaabu/forms-blade": here("./js") } },
  logLevel: "warn",
  build: {
    outDir: "out",
    rollupOptions: {
      input: ["js/forms.ts", "js/select.ts", "js/dates.ts", "js/files.ts", "js/wysiwyg.ts", "css/select.css", "css/dates.css", "css/onu-standalone.css"],
      onLog(level, log, handler) {
        if (log.code === "MODULE_LEVEL_DIRECTIVE") return
        handler(level, log)
      },
    },
  },
})
JS

cd "$app"
# The app's own build tools, which manifest:check also lists (vite) or which a Tailwind app has.
npm install --legacy-peer-deps --no-audit --no-fund --loglevel=error "${requirements[@]}" "vite@^8" "@tailwindcss/vite@^4"
npx vite build
echo "Built forms' Blade assets with only the declared npm packages."
