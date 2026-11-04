/**
 * File and image inputs.
 *
 * `[data-provides="fileinput"]` works like Jasny's fileinput: choosing a file
 * swaps the wrapper's `fileinput-new` class for `fileinput-exists`, writes the
 * name into `.fileinput-filename` and previews images in `.fileinput-preview img`.
 * `[data-dismiss="fileinput"]` clears it and `[data-trigger="fileinput"]` opens the picker.
 *
 * `[data-provides="fileinput-upload"]` uploads the chosen file straight away to the
 * surrounding form's action (a port of js-utilities' file-upload-input.js), after
 * checking `data-max-file-size` (KB, default 2 MB) and the `accept` types, then reloads
 * the page. Its remove button clears the field on the server after a `confirm()`.
 */
import { all, autoInit, escapeHtml, once } from "./dom"
import { __ } from "./lang"

const ROOT = '[data-provides="fileinput"], [data-provides="fileinput-upload"]'

const SPINNER =
  '<svg class="forms-spinner" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56"><animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="0.8s" repeatCount="indefinite"/></path></svg>'

function fileInputOf(root: Element): HTMLInputElement | null {
  return root.querySelector<HTMLInputElement>('input[type="file"]')
}

function setExists(root: Element, exists: boolean): void {
  root.classList.toggle("fileinput-exists", exists)
  root.classList.toggle("fileinput-new", !exists)
}

function setFilename(root: Element, name: string): void {
  root.querySelectorAll(".fileinput-filename").forEach((el) => {
    el.textContent = name
  })
}

function preview(root: Element, file: File | undefined): void {
  const img = root.querySelector<HTMLImageElement>(".fileinput-preview img")
  if (!img) return

  if (!file || !file.type.startsWith("image/") || typeof FileReader === "undefined") {
    img.removeAttribute("src")
    return
  }

  const reader = new FileReader()
  reader.onload = () => {
    if (typeof reader.result === "string") img.src = reader.result
  }
  reader.readAsDataURL(file)
}

/** Shows the chosen file(s) in a Jasny-style file input. */
export function select(root: Element, input: HTMLInputElement): void {
  const files = Array.from(input.files ?? [])

  if (!files.length) {
    clear(root)
    return
  }

  setFilename(root, files.map((file) => file.name).join(", "))
  preview(root, files[0])
  setExists(root, true)
}

/** Empties a Jasny-style file input. */
export function clear(root: Element): void {
  const input = fileInputOf(root)
  if (input) input.value = ""

  setFilename(root, "")
  preview(root, undefined)
  setExists(root, false)
}

/* Upload ------------------------------------------------------------------ */

const uploading = new WeakSet<Element>()

/** What happens after an upload or removal succeeds: the page reloads, as with the jQuery version. */
export const after = {
  success: (): void => window.location.reload(),
}

/** Whether the file matches the input's `accept` list (MIME types, `type/*` and `.ext`). */
export function accepts(accept: string, file: File): boolean {
  const types = accept
    .split(",")
    .map((type) => type.trim())
    .filter(Boolean)

  if (!types.length) return true

  return types.some((type) => {
    if (type.startsWith(".")) return file.name.toLowerCase().endsWith(type.toLowerCase())

    const pattern = new RegExp(`^${type.replace(/[.+?^${}()|[\]\\]/g, "\\$&").replace(/\*/g, ".*")}$`, "i")
    return pattern.test(file.type)
  })
}

/** Where the field's errors go: its `<x-forms::js-errors>` list, if the page has one. */
function errorList(input: HTMLInputElement): Element | null {
  const name = input.name.replace(/\[\]$/, "")

  return document.getElementsByClassName(`${name}-error`)[0] ?? null
}

/** Shows an error for the field, in its error list or else in an alert. */
export function showError(input: HTMLInputElement, message: string): void {
  const list = errorList(input)

  if (!list) {
    window.alert(message)
    return
  }

  const item = document.createElement("li")
  item.textContent = message
  list.replaceChildren(item)

  input.setAttribute("aria-invalid", "true")
  input.classList.add("is-invalid")
  input.closest(ROOT)?.classList.add("is-invalid")
}

function clearError(input: HTMLInputElement): void {
  errorList(input)?.replaceChildren()
  input.removeAttribute("aria-invalid")
  input.classList.remove("is-invalid")
  input.closest(ROOT)?.classList.remove("is-invalid")
}

interface Target {
  url: string
  method: string
  token: string | null
}

/** The form's action and method (`_method` when it spoofs one), like the jQuery version read them. */
function targetOf(form: HTMLFormElement): Target {
  const spoofed = form.querySelector<HTMLInputElement>('input[name="_method"]')?.value

  return {
    url: form.getAttribute("action") || window.location.href,
    method: (spoofed || form.getAttribute("method") || "POST").toUpperCase(),
    token:
      form.querySelector<HTMLInputElement>('input[name="_token"]')?.value ??
      document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.content ??
      null,
  }
}

async function send(target: Target, body: FormData | URLSearchParams): Promise<Response> {
  if (target.method !== "POST") body.append("_method", target.method)

  const headers: Record<string, string> = { Accept: "application/json", "X-Requested-With": "XMLHttpRequest" }
  if (target.token) headers["X-CSRF-TOKEN"] = target.token

  return fetch(target.url, { method: "POST", body, headers, credentials: "same-origin" })
}

/** A 422 response's message for the field, as Laravel's validation errors give it. */
async function validationMessage(response: Response, input: HTMLInputElement): Promise<string | null> {
  try {
    const body = (await response.json()) as { message?: string; errors?: Record<string, string[]> }
    const name = input.name.replace(/\[\]$/, "").replace(/\[([^\]]*)\]/g, ".$1")
    const errors = body.errors ?? {}
    const messages = errors[name] ?? errors[`${name}.0`] ?? Object.values(errors)[0]

    return messages?.[0] ?? body.message ?? null
  } catch {
    return null
  }
}

function setLoading(button: HTMLElement | null, text: string): () => void {
  if (!button) return () => undefined

  const html = button.innerHTML
  button.innerHTML = `${SPINNER} ${escapeHtml(text)}`
  button.setAttribute("aria-busy", "true")
  button.classList.add("disabled")

  return () => {
    button.innerHTML = html
    button.removeAttribute("aria-busy")
    button.classList.remove("disabled")
  }
}

async function request(
  root: Element,
  input: HTMLInputElement,
  button: HTMLElement | null,
  status: string,
  failure: string,
  body: FormData | URLSearchParams,
): Promise<void> {
  const form = input.closest("form")
  if (!form) return

  uploading.add(root)
  const restore = setLoading(button, status)

  try {
    const response = await send(targetOf(form), body)

    if (response.ok) {
      after.success()
      return
    }

    restore()
    showError(input, (response.status === 422 && (await validationMessage(response, input))) || failure)
  } catch {
    restore()
    showError(input, failure)
  } finally {
    uploading.delete(root)
  }
}

/** Checks and uploads the chosen file. */
export async function upload(root: Element, input: HTMLInputElement): Promise<void> {
  if (uploading.has(root)) return

  const file = input.files?.[0]
  if (!file) return

  clearError(input)

  const max = Number(input.getAttribute("data-max-file-size")) || 2 * 1024
  if (Math.round(file.size / 1024) > max) {
    showError(input, __("forms::strings.file_too_large", { size: Math.round(max / 1024) }))
    input.value = ""
    return
  }

  if (!accepts(input.accept, file)) {
    showError(input, __("forms::strings.file_type_not_allowed", { accept: input.accept }))
    input.value = ""
    return
  }

  const body = new FormData()
  body.append(input.name, file)

  await request(
    root,
    input,
    root.querySelector<HTMLElement>(".upload-btn"),
    __("forms::strings.uploading"),
    __("forms::strings.upload_error"),
    body,
  )
}

/** Clears the field on the server, once the user confirms. */
export async function remove(root: Element, button: HTMLElement): Promise<void> {
  if (uploading.has(root)) return

  const input = fileInputOf(root)
  if (!input || !input.closest("form")) return

  const question = `${__("forms::strings.are_you_sure")}\n${__("forms::strings.remove_file_confirm")}`
  if (!window.confirm(question)) return

  clearError(input)

  const body = new URLSearchParams()
  body.append(input.name, "")

  await request(root, input, button, __("forms::strings.removing"), __("forms::strings.remove_error"), body)
}

/* Events ------------------------------------------------------------------ */

function onChange(event: Event): void {
  const input = event.target
  if (!(input instanceof HTMLInputElement) || input.type !== "file") return

  const root = input.closest(ROOT)
  if (!root) return

  if (root.getAttribute("data-provides") === "fileinput-upload") void upload(root, input)
  else select(root, input)
}

function onClick(event: MouseEvent): void {
  const target = event.target
  if (!(target instanceof Element)) return

  const root = target.closest(ROOT)
  if (!root) return

  const upload = root.getAttribute("data-provides") === "fileinput-upload"

  const dismiss = target.closest<HTMLElement>('[data-dismiss="fileinput"]')
  if (dismiss) {
    event.preventDefault()
    if (upload) void remove(root, dismiss)
    else clear(root)
    return
  }

  if (target.closest('[data-trigger="fileinput"]')) {
    event.preventDefault()
    if (!upload || !uploading.has(root)) fileInputOf(root)?.click()
  }
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("change", onChange)
    document.addEventListener("click", onClick)
    listening = true
  }

  // Events are delegated, so this only marks the inputs.
  all(root, ROOT).forEach((el) => once(el, "files"))
}

autoInit(init)
