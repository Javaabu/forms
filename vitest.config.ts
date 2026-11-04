import { defineConfig } from "vitest/config"

export default defineConfig({
  test: {
    environment: "jsdom",
    include: ["tests/js/**/*.test.ts"],
    setupFiles: ["tests/js/setup.ts"],
    css: false,
    coverage: {
      provider: "v8",
      include: ["resources/js/**/*.ts"],
      reporter: ["text", "clover", "lcov"],
      reportsDirectory: "coverage",
      thresholds: { lines: 95, statements: 95, functions: 90, branches: 85 },
    },
  },
})
