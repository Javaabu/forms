import { afterEach, vi } from "vitest"

// The modules enhance the page by themselves when loaded; tests call init() instead.
document.documentElement.setAttribute("data-forms-manual", "")

afterEach(() => {
  document.body.replaceChildren()
  document.documentElement.setAttribute("lang", "en")
  document.documentElement.removeAttribute("dir")
  vi.restoreAllMocks()
  vi.unstubAllGlobals()
  vi.useRealTimers()
})
