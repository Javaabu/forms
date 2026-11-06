import tailwindcss from "@tailwindcss/vite"
import { defineConfig } from "vite"

/**
 * Builds the prebuilt assets in dist/ for apps that don't build javaabu/forms with
 * their own Vite. javaabu/manifest finds them through dist/.vite/manifest.json, keyed
 * by these entry paths. Third-party libraries are bundled in; dist/ is committed.
 */
export const entries = [
  "resources/js/forms.ts",
  "resources/js/select.ts",
  "resources/js/dates.ts",
  "resources/js/files.ts",
  "resources/js/wysiwyg.ts",
  "resources/css/select.css",
  "resources/css/dates.css",
  "resources/css/onu-standalone.css",
]

export default defineConfig({
  plugins: [tailwindcss()],
  // Relative URLs (fonts in the CSS), as javaabu/manifest serves dist/ from a sub-path.
  base: "./",
  publicDir: false,
  build: {
    outDir: "dist",
    emptyOutDir: true,
    manifest: true,
    target: "es2020",
    // Tailwind v4's baseline, so modern colors aren't given old-browser fallbacks.
    cssTarget: ["chrome111", "edge111", "firefox128", "safari16.4"],
    sourcemap: false,
    reportCompressedSize: false,
    rollupOptions: {
      input: entries,
      onLog(level, log, handler) {
        // @javaabu/onu marks its modules "use client" for React; it means nothing here.
        if (log.code === "MODULE_LEVEL_DIRECTIVE") return
        handler(level, log)
      },
    },
  },
})
