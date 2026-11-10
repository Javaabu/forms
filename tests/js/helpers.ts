import { vi } from "vitest"

/** Puts markup in the page and returns the body. */
export function html(markup: string): HTMLElement {
  document.body.innerHTML = markup
  return document.body
}

export function $<T extends Element = HTMLElement>(selector: string): T {
  const el = document.querySelector<T>(selector)
  if (!el) throw new Error(`No element matches ${selector}`)
  return el
}

/** Fires a bubbling event, as the browser does. */
export function fire(el: EventTarget, type = "change"): void {
  el.dispatchEvent(new Event(type, { bubbles: true }))
}

export function click(el: Element, init: MouseEventInit = {}): MouseEvent {
  const event = new MouseEvent("click", { bubbles: true, cancelable: true, ...init })
  el.dispatchEvent(event)
  return event
}

export function key(el: Element, keyName: string): KeyboardEvent {
  const event = new KeyboardEvent("keydown", { key: keyName, bubbles: true, cancelable: true })
  el.dispatchEvent(event)
  return event
}

/** Lets promises, mutation observers and zero timeouts run. */
export async function flush(times = 3): Promise<void> {
  for (let i = 0; i < times; i++) {
    if (vi.isFakeTimers()) await vi.advanceTimersByTimeAsync(1)
    else await new Promise((resolve) => setTimeout(resolve, 0))
  }
}

export function jsonResponse(body: unknown, status = 200): Response {
  return new Response(JSON.stringify(body), { status, headers: { "Content-Type": "application/json" } })
}

/** Stubs fetch with responses (or errors) in order, and returns the mock. */
export function mockFetch(...responses: (Response | Error | (() => Response | Promise<Response>))[]) {
  const fetch = vi.fn(async () => {
    const next = responses.shift()
    if (next === undefined) throw new Error("Unexpected fetch")
    if (next instanceof Error) throw next
    return typeof next === "function" ? next() : next
  })
  vi.stubGlobal("fetch", fetch)
  return fetch
}

/** The URL of the nth fetch call, decoded for readable assertions. */
export function calledUrl(fetch: ReturnType<typeof mockFetch>, index = 0): string {
  const call = fetch.mock.calls[index] as unknown as [string]
  return decodeURIComponent(call[0])
}

/** Sets the files of a file input. */
export function setFiles(input: HTMLInputElement, files: File[]): void {
  Object.defineProperty(input, "files", { configurable: true, value: files })
}
