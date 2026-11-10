import { afterEach, beforeEach, describe, expect, it, vi } from "vitest"

import { activateTab, closeDialog, init, openDialog } from "../../resources/js/widgets"
import { $, click, html, key } from "./helpers"

describe("alerts", () => {
  it("removes the dismissed callout", () => {
    html(`<div data-slot="callout" id="c">ސޭވްކުރެވިއްޖެ<button data-dismiss="alert" id="x">x</button></div>`)
    init()
    click($("#x"))
    expect(document.querySelector("#c")).toBeNull()
  })

  it("ignores Bootstrap alerts", () => {
    html(`<div class="alert" id="c"><button data-bs-dismiss="alert" id="x">x</button></div>
      <div class="alert" id="d"><button data-dismiss="alert" id="y">x</button></div>`)
    init()
    click($("#x"))
    click($("#y"))
    expect(document.querySelector("#c")).not.toBeNull()
    expect(document.querySelector("#d")).not.toBeNull()
  })
})

describe("dialogs", () => {
  const markup = `
    <button id="open" data-forms-toggle="modal" data-target="#dialog">ހުޅުވާ</button>
    <a id="open2" href="#" data-modal-target="#dialog">ހުޅުވާ</a>
    <button id="bad" data-modal-target="[[">x</button>
    <button id="notdialog" data-modal-target="#div">x</button><div id="div"></div>
    <dialog class="forms-dialog" id="dialog"><button id="close" data-dismiss="modal">ބަންދުކުރޭ</button><p id="body">ތެރެ</p></dialog>`

  describe("without showModal", () => {
    it("opens and closes with the open attribute", () => {
      html(markup)
      init()
      expect($("#dialog").getAttribute("data-state")).toBe("closed")

      const event = click($("#open2"))
      expect(event.defaultPrevented).toBe(true)
      expect($<HTMLDialogElement>("#dialog").hasAttribute("open")).toBe(true)
      expect($("#dialog").getAttribute("data-state")).toBe("open")

      click($("#close"))
      expect($<HTMLDialogElement>("#dialog").hasAttribute("open")).toBe(false)
      expect($("#dialog").getAttribute("data-state")).toBe("closed")

      click($("#bad"))
      click($("#notdialog"))
    })
  })

  describe("with showModal", () => {
    beforeEach(() => {
      HTMLDialogElement.prototype.showModal = function (this: HTMLDialogElement) {
        this.setAttribute("open", "")
      }
      HTMLDialogElement.prototype.close = function (this: HTMLDialogElement) {
        this.removeAttribute("open")
        this.dispatchEvent(new Event("close"))
      }
    })

    afterEach(() => {
      delete (HTMLDialogElement.prototype as Partial<HTMLDialogElement>).showModal
      delete (HTMLDialogElement.prototype as Partial<HTMLDialogElement>).close
    })

    it("opens with showModal and keeps data-state", () => {
      html(markup)
      init()
      click($("#open"))
      expect($<HTMLDialogElement>("#dialog").open).toBe(true)
      expect($("#dialog").getAttribute("data-state")).toBe("open")

      openDialog($("#dialog"))
      expect($("#dialog").getAttribute("data-state")).toBe("open")

      // Escape closes natively; the close event updates the state.
      $<HTMLDialogElement>("#dialog").close()
      expect($("#dialog").getAttribute("data-state")).toBe("closed")
    })

    it("closes on a backdrop click only", () => {
      html(markup)
      init()
      openDialog($("#dialog"))
      vi.spyOn($("#dialog"), "getBoundingClientRect").mockReturnValue(new DOMRect(100, 100, 200, 200))

      click($("#body"), { clientX: 10, clientY: 10, detail: 1 })
      expect($<HTMLDialogElement>("#dialog").open).toBe(true)

      click($("#dialog"), { clientX: 150, clientY: 150, detail: 1 })
      expect($<HTMLDialogElement>("#dialog").open).toBe(true)

      click($("#dialog"), { clientX: 0, clientY: 0, detail: 0 })
      expect($<HTMLDialogElement>("#dialog").open).toBe(true)

      click($("#dialog"), { clientX: 10, clientY: 150, detail: 1 })
      expect($<HTMLDialogElement>("#dialog").open).toBe(false)
    })

    it("closes programmatically", () => {
      html(markup)
      init()
      openDialog($("#dialog"))
      closeDialog($("#dialog"))
      expect($("#dialog").getAttribute("data-state")).toBe("closed")
    })
  })
})

describe("tabs", () => {
  const tabs = (dir = "ltr") => `
    <div dir="${dir}">
      <div role="tablist">
        <button role="tab" id="t1" data-tab-target="#p1" aria-selected="true" data-state="active" tabindex="0">ފުރަތަމަ</button>
        <button role="tab" id="t2" data-tab-target="#p2" aria-selected="false" data-state="inactive" tabindex="-1">ދެވަނަ</button>
        <button role="tab" id="t3" data-tab-target="#p3" disabled>ތިންވަނަ</button>
        <button role="tab" id="t4" data-tab-target="#p4" aria-selected="false" tabindex="-1">ހަތަރުވަނަ</button>
      </div>
      <div role="tabpanel" id="p1" class="active">1</div>
      <div role="tabpanel" id="p2" class="hidden">2</div>
      <div role="tabpanel" id="p4" class="hidden">4</div>
    </div>`

  it("switches tabs on click", () => {
    html(tabs())
    init()
    click($("#t2"))

    expect($("#t2").getAttribute("aria-selected")).toBe("true")
    expect($("#t2").getAttribute("data-state")).toBe("active")
    expect($("#t2").tabIndex).toBe(0)
    expect($("#t1").getAttribute("aria-selected")).toBe("false")
    expect($("#t1").tabIndex).toBe(-1)
    expect($("#p2").classList.contains("hidden")).toBe(false)
    expect($("#p2").getAttribute("data-state")).toBe("active")
    expect($("#p1").classList.contains("hidden")).toBe(true)
    expect($("#p1").classList.contains("active")).toBe(false)

    click($("#t3"))
    expect($("#t2").getAttribute("aria-selected")).toBe("true")
  })

  it("moves with the arrow keys, skipping disabled tabs", () => {
    html(tabs())
    init()
    $("#t1").focus()

    key($("#t1"), "ArrowRight")
    expect(document.activeElement).toBe($("#t2"))
    key($("#t2"), "ArrowRight")
    expect(document.activeElement).toBe($("#t4"))
    key($("#t4"), "ArrowRight")
    expect(document.activeElement).toBe($("#t1"))
    key($("#t1"), "ArrowLeft")
    expect(document.activeElement).toBe($("#t4"))
    key($("#t4"), "Home")
    expect(document.activeElement).toBe($("#t1"))
    key($("#t1"), "End")
    expect(document.activeElement).toBe($("#t4"))
    expect(key($("#t4"), "a").defaultPrevented).toBe(false)
  })

  it("reverses the arrow keys right to left", () => {
    html(tabs("rtl"))
    init()
    key($("#t1"), "ArrowLeft")
    expect($("#t2").getAttribute("aria-selected")).toBe("true")
    key($("#t2"), "ArrowRight")
    expect($("#t1").getAttribute("aria-selected")).toBe("true")
  })

  it("uses up and down for vertical tabs", () => {
    html(tabs().replace('role="tablist"', 'role="tablist" aria-orientation="vertical"'))
    init()
    key($("#t1"), "ArrowDown")
    expect($("#t2").getAttribute("aria-selected")).toBe("true")
    key($("#t2"), "ArrowUp")
    expect($("#t1").getAttribute("aria-selected")).toBe("true")
  })

  it("handles missing panels", () => {
    html(`<div role="tablist"><button role="tab" id="a" data-tab-target="[[">x</button>
      <button role="tab" id="b" data-tab-target="#none">y</button></div>`)
    activateTab($("#a"))
    expect($("#a").getAttribute("aria-selected")).toBe("true")
  })
})

describe("menus", () => {
  const menu = `
    <details data-forms-menu id="m" open><summary id="s">ބޭނުންތައް</summary>
      <div role="menu"><button role="menuitem" id="item" type="button">XLSX</button><span id="inside">x</span></div>
    </details>
    <p id="outside">ބޭރު</p>`

  it("closes on an outside click", () => {
    html(menu)
    init()
    click($("#inside"))
    expect($<HTMLDetailsElement>("#m").open).toBe(true)
    click($("#outside"))
    expect($<HTMLDetailsElement>("#m").open).toBe(false)
  })

  it("closes when an item is chosen", () => {
    html(menu)
    init()
    click($("#item"))
    expect($<HTMLDetailsElement>("#m").open).toBe(false)
  })

  it("closes on Escape and returns focus to the summary", () => {
    html(menu)
    init()
    key($("#item"), "Escape")
    expect($<HTMLDetailsElement>("#m").open).toBe(false)
    expect(document.activeElement).toBe($("#s"))
    key($("#outside"), "Escape")
  })

  it("closes on clicks on the document itself", () => {
    html(menu)
    init()
    document.dispatchEvent(new MouseEvent("click", { bubbles: true }))
    expect($<HTMLDetailsElement>("#m").open).toBe(false)
    document.dispatchEvent(new KeyboardEvent("keydown", { key: "Escape" }))
  })
})
