import { beforeEach, describe, expect, it, vi } from "vitest"

import { accepts, after, clear, init, remove, select, showError, upload } from "../../resources/js/files"
import { $, click, fire, flush, html, jsonResponse, mockFetch, setFiles } from "./helpers"

const image = (name = "ފޮޓޯ.png", type = "image/png", size = 10) => new File(["x".repeat(size)], name, { type })

const fileInput = `
  <div id="root" class="fileinput fileinput-new" data-provides="fileinput">
    <span class="fileinput-filename hidden"></span>
    <span class="btn-file"><span class="fileinput-filename fileinput-exists"></span><input type="file" name="document" id="file"></span>
    <button type="button" id="dismiss" data-dismiss="fileinput"><svg id="icon"></svg></button>
  </div>`

const imageInput = `
  <div id="root" class="fileinput fileinput-exists" data-provides="fileinput">
    <div data-trigger="fileinput" id="trigger"><div class="fileinput-preview"><img id="img" src="/old.png" alt=""></div></div>
    <span class="btn-file"><input type="file" name="avatar" id="file" accept="image/*"></span>
    <button type="button" id="dismiss" data-dismiss="fileinput">ފޮހެލާ</button>
  </div>`

const uploadInput = (form = `action="/users/1" method="POST"`, extra = "") => `
  <form ${form}>
    <input type="hidden" name="_token" value="secret">
    ${extra}
    <div id="root" class="fileinput fileinput-exists" data-provides="fileinput-upload">
      <div data-trigger="fileinput" id="trigger"></div>
      <span class="btn-file"><span class="btn-file-selector upload-btn" id="upload">Upload file</span>
        <input type="file" name="avatar" id="file" accept="image/png, .pdf" data-max-file-size="1024"></span>
      <button type="button" id="dismiss" data-dismiss="fileinput">Remove</button>
    </div>
    <ul class="avatar-error" id="errors"></ul>
  </form>`

const file = () => $<HTMLInputElement>("#file")

describe("file inputs", () => {
  it("shows the chosen file's name", () => {
    html(fileInput)
    init()
    init()

    setFiles(file(), [image("ލިޔުން.pdf", "application/pdf")])
    fire(file())

    expect($("#root").classList.contains("fileinput-exists")).toBe(true)
    expect($("#root").classList.contains("fileinput-new")).toBe(false)
    expect(document.querySelectorAll(".fileinput-filename")[1]?.textContent).toBe("ލިޔުން.pdf")
    expect($("#root").getAttribute("data-forms-ready")).toBe("files")
  })

  it("lists several files", () => {
    html(fileInput)
    setFiles(file(), [image("a.pdf"), image("b.pdf")])
    select($("#root"), file())
    expect($(".fileinput-filename").textContent).toBe("a.pdf, b.pdf")
  })

  it("clears when the picker is cancelled or dismissed", () => {
    html(fileInput)
    init()

    setFiles(file(), [image()])
    fire(file())
    setFiles(file(), [])
    fire(file())
    expect($("#root").classList.contains("fileinput-new")).toBe(true)

    setFiles(file(), [image()])
    fire(file())
    expect(click($("#icon")).defaultPrevented).toBe(true)
    expect($("#root").classList.contains("fileinput-new")).toBe(true)
    expect($(".fileinput-filename").textContent).toBe("")
  })

  it("previews images", async () => {
    html(imageInput)
    init()

    setFiles(file(), [image()])
    fire(file())
    await vi.waitFor(() => expect($<HTMLImageElement>("#img").src).toMatch(/^data:image\/png;base64,/))

    clear($("#root"))
    expect($("#img").hasAttribute("src")).toBe(false)
  })

  it("doesn't preview other files", () => {
    html(imageInput)
    setFiles(file(), [image("a.pdf", "application/pdf")])
    select($("#root"), file())
    expect($("#img").hasAttribute("src")).toBe(false)
  })

  it("opens the picker from the preview", () => {
    html(imageInput)
    init()
    const open = vi.spyOn(file(), "click")
    click($("#img"))
    expect(open).toHaveBeenCalledOnce()
  })

  it("ignores clicks and changes elsewhere", () => {
    html(`<input type="file" id="loose"><input id="text"><p id="p"></p>`)
    init()
    fire($("#loose"))
    fire($("#text"))
    click($("#p"))
    document.dispatchEvent(new MouseEvent("click", { bubbles: true }))
  })
})

describe("accepted types", () => {
  it("matches MIME types, wildcards and extensions", () => {
    expect(accepts("image/*", image())).toBe(true)
    expect(accepts("image/png, application/pdf", image("a.pdf", "application/pdf"))).toBe(true)
    expect(accepts(".PDF", image("ލިޔުން.pdf", ""))).toBe(true)
    expect(accepts("image/jpeg", image())).toBe(false)
    expect(accepts("", image())).toBe(true)
  })
})

describe("upload inputs", () => {
  beforeEach(() => {
    vi.spyOn(after, "success").mockImplementation(() => undefined)
  })

  it("uploads the file to the form's action, then reloads", async () => {
    html(uploadInput())
    init()
    const fetch = mockFetch(jsonResponse({}))

    setFiles(file(), [image()])
    fire(file())
    expect($("#upload").textContent).toContain("Uploading...")
    expect($("#upload").getAttribute("aria-busy")).toBe("true")
    await flush()

    const [url, request] = fetch.mock.calls[0] as unknown as [string, RequestInit]
    expect(url).toBe("/users/1")
    expect(request.method).toBe("POST")
    expect((request.body as FormData).get("avatar")).toBeInstanceOf(File)
    expect((request.body as FormData).has("_method")).toBe(false)
    expect(request.headers).toMatchObject({ "X-CSRF-TOKEN": "secret", Accept: "application/json" })
    expect(after.success).toHaveBeenCalledOnce()
  })

  it("spoofs the form's method", async () => {
    html(uploadInput(`action="/users/1" method="POST"`, `<input type="hidden" name="_method" value="patch">`))
    const fetch = mockFetch(jsonResponse({}))

    setFiles(file(), [image()])
    await upload($("#root"), file())
    const request = (fetch.mock.calls[0] as unknown as [string, RequestInit])[1]
    expect((request.body as FormData).get("_method")).toBe("PATCH")
  })

  it("uses the page URL and the csrf meta tag when the form has neither", async () => {
    html(
      `<meta name="csrf-token" content="meta-token">${uploadInput("").replace('<input type="hidden" name="_token" value="secret">', "")}`,
    )
    const fetch = mockFetch(jsonResponse({}))

    setFiles(file(), [image()])
    await upload($("#root"), file())
    const [url, request] = fetch.mock.calls[0] as unknown as [string, RequestInit]
    expect(url).toBe(window.location.href)
    expect(request.headers).toMatchObject({ "X-CSRF-TOKEN": "meta-token" })
  })

  it("rejects files that are too large", async () => {
    document.documentElement.setAttribute("lang", "dv")
    html(uploadInput())
    const fetch = mockFetch()

    setFiles(file(), [image("big.png", "image/png", 2 * 1024 * 1024)])
    await upload($("#root"), file())

    expect(fetch).not.toHaveBeenCalled()
    expect($("#errors").textContent).toBe("ފައިލްގެ ސައިޒު 1 MB އަށްވުރެ ބޮޑުވެގެން ނުވާނެ")
    expect(file().getAttribute("aria-invalid")).toBe("true")
    expect($("#root").classList.contains("is-invalid")).toBe(true)
  })

  it("defaults the maximum to 2 MB", async () => {
    html(uploadInput())
    file().removeAttribute("data-max-file-size")
    mockFetch()
    setFiles(file(), [image("big.png", "image/png", 3 * 1024 * 1024)])
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("File size cannot be greater than 2 MB")
  })

  it("rejects other types", async () => {
    html(uploadInput())
    mockFetch()
    setFiles(file(), [image("a.gif", "image/gif")])
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("Only image/png, .pdf files are allowed.")
  })

  it("shows validation errors and restores the button", async () => {
    html(uploadInput())
    mockFetch(jsonResponse({ message: "x", errors: { avatar: ["ފޮޓޯ ބޮޑުވެއްޖެ"] } }, 422))

    setFiles(file(), [image()])
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("ފޮޓޯ ބޮޑުވެއްޖެ")
    expect($("#upload").textContent).toBe("Upload file")
    expect($("#upload").hasAttribute("aria-busy")).toBe(false)
    expect(after.success).not.toHaveBeenCalled()

    // A later valid choice clears the error first.
    mockFetch(jsonResponse({}))
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("")
  })

  it("falls back to the message or a generic error", async () => {
    html(uploadInput())
    setFiles(file(), [image()])

    mockFetch(jsonResponse({ message: "ގޯސް" }, 422))
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("ގޯސް")

    mockFetch(new Response("not json", { status: 422 }))
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("An error occurred while uploading the file.")

    mockFetch(jsonResponse({}, 500))
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("An error occurred while uploading the file.")

    mockFetch(new Error("offline"))
    await upload($("#root"), file())
    expect($("#errors").textContent).toBe("An error occurred while uploading the file.")
  })

  it("alerts when the field has no error list", () => {
    html(`<input type="file" name="x" id="file">`)
    const alert = vi.spyOn(window, "alert").mockImplementation(() => undefined)
    showError(file(), "ގޯސް")
    expect(alert).toHaveBeenCalledWith("ގޯސް")
  })

  it("ignores changes while uploading, without files or outside a form", async () => {
    html(uploadInput())
    let release: (r: Response) => void = () => undefined
    const fetch = mockFetch(() => new Promise<Response>((resolve) => (release = resolve)))
    init()

    setFiles(file(), [image()])
    fire(file())
    fire(file())
    click($("#trigger"))
    await remove($("#root"), $("#dismiss"))
    expect(fetch).toHaveBeenCalledOnce()

    release(jsonResponse({}))
    await flush()

    setFiles(file(), [])
    await upload($("#root"), file())

    html(uploadInput().replace("<form", "<div").replace("</form>", "</div>"))
    setFiles(file(), [image()])
    await upload($("#root"), file())
    await remove($("#root"), $("#dismiss"))
    expect(fetch).toHaveBeenCalledOnce()
  })

  it("opens the picker from the trigger", () => {
    html(uploadInput())
    init()
    const open = vi.spyOn(file(), "click")
    click($("#trigger"))
    expect(open).toHaveBeenCalledOnce()
  })

  it("removes the file on the server after confirming", async () => {
    document.documentElement.setAttribute("lang", "dv")
    html(uploadInput(`action="/users/1" method="POST"`, `<input type="hidden" name="_method" value="PUT">`))
    init()
    const confirm = vi.spyOn(window, "confirm").mockReturnValueOnce(false).mockReturnValueOnce(true)
    const fetch = mockFetch(jsonResponse({}))

    click($("#dismiss"))
    expect(fetch).not.toHaveBeenCalled()
    expect(confirm).toHaveBeenCalledWith("ކަށަވަރުތަ؟\nމި ފައިލް ފޮހެލުމަށްފަހު އަނބުރާ ނުގެނެވޭނެ!")

    click($("#dismiss"))
    expect($("#dismiss").textContent).toContain("ފޮހެލަނީ…")
    await flush()

    const request = (fetch.mock.calls[0] as unknown as [string, RequestInit])[1]
    expect(String(request.body)).toBe("avatar=&_method=PUT")
    expect(after.success).toHaveBeenCalledOnce()
  })

  it("shows remove errors", async () => {
    html(uploadInput())
    vi.spyOn(window, "confirm").mockReturnValue(true)
    mockFetch(jsonResponse({}, 500))

    await remove($("#root"), $("#dismiss"))
    expect($("#errors").textContent).toBe("An error occurred while removing the file.")
    expect($("#dismiss").textContent).toBe("Remove")
  })

  it("does nothing to remove without a file input", async () => {
    html(`<form><div id="root" data-provides="fileinput-upload"><button id="dismiss"></button></div></form>`)
    const confirm = vi.spyOn(window, "confirm")
    await remove($("#root"), $("#dismiss"))
    expect(confirm).not.toHaveBeenCalled()
  })
})
