/**
 * The Onu views' small widgets. Bootstrap handles its own (`data-bs-*`), and none
 * of the selectors here match Bootstrap's markup.
 *
 * - Alerts: `[data-dismiss="alert"]` removes its `[data-slot="callout"]`.
 * - Dialogs: `<dialog class="forms-dialog">` opens with `[data-forms-toggle="modal"][data-target="#id"]`
 *   or `[data-modal-target="#id"]`, and closes with `[data-dismiss="modal"]`, a backdrop click
 *   or Escape. It keeps `data-state="open" | "closed"`.
 * - Tabs: `[role="tablist"] [role="tab"][data-tab-target="#panel"]`, with arrow keys
 *   (reversed in right-to-left), Home and End.
 * - Menus: an open `details[data-forms-menu]` closes on an outside click, Escape, or
 *   choosing one of its items.
 */
import { all, isRtl, once } from "./dom"

const MODAL_TRIGGER = '[data-forms-toggle="modal"][data-target], [data-modal-target]'
const TAB = '[role="tab"][data-tab-target]'
const MENU = "details[data-forms-menu]"

function setState(dialog: HTMLDialogElement): void {
  dialog.setAttribute("data-state", dialog.open ? "open" : "closed")
}

export function openDialog(dialog: HTMLDialogElement): void {
  if (!dialog.open) {
    if (typeof dialog.showModal === "function") dialog.showModal()
    else dialog.setAttribute("open", "")
  }

  setState(dialog)
}

export function closeDialog(dialog: HTMLDialogElement): void {
  if (typeof dialog.close === "function") dialog.close()
  else dialog.removeAttribute("open")

  setState(dialog)
}

function dialogFor(trigger: Element): HTMLDialogElement | null {
  const selector = trigger.getAttribute("data-modal-target") ?? trigger.getAttribute("data-target")

  try {
    const target = selector ? document.querySelector(selector) : null
    return target instanceof HTMLDialogElement ? target : null
  } catch {
    return null
  }
}

function isBackdropClick(dialog: HTMLDialogElement, event: MouseEvent): boolean {
  if (event.target !== dialog) return false

  const rect = dialog.getBoundingClientRect()
  // Keyboard "clicks" have no position; only pointer clicks outside the box count.
  if (event.clientX === 0 && event.clientY === 0 && event.detail === 0) return false

  return (
    event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom
  )
}

function tabsOf(tab: Element): HTMLElement[] {
  const list = tab.closest('[role="tablist"]')

  return list ? Array.from(list.querySelectorAll<HTMLElement>(TAB)) : []
}

function panelOf(tab: Element): HTMLElement | null {
  try {
    return document.querySelector<HTMLElement>(tab.getAttribute("data-tab-target") ?? "")
  } catch {
    return null
  }
}

export function activateTab(tab: HTMLElement): void {
  for (const other of tabsOf(tab)) {
    const active = other === tab

    other.setAttribute("data-state", active ? "active" : "inactive")
    other.setAttribute("aria-selected", active ? "true" : "false")
    other.tabIndex = active ? 0 : -1

    const panel = panelOf(other)
    if (panel) {
      panel.classList.toggle("hidden", !active)
      panel.classList.toggle("active", active)
      panel.setAttribute("data-state", active ? "active" : "inactive")
    }
  }
}

function onTabKey(tab: HTMLElement, event: KeyboardEvent): void {
  const tabs = tabsOf(tab).filter((el) => !el.hasAttribute("disabled"))
  const index = tabs.indexOf(tab)
  const vertical = tab.closest('[role="tablist"]')?.getAttribute("aria-orientation") === "vertical"
  const forward = vertical ? "ArrowDown" : isRtl(tab) ? "ArrowLeft" : "ArrowRight"
  const back = vertical ? "ArrowUp" : isRtl(tab) ? "ArrowRight" : "ArrowLeft"

  let next: HTMLElement | undefined
  if (event.key === forward) next = tabs[(index + 1) % tabs.length]
  else if (event.key === back) next = tabs[(index - 1 + tabs.length) % tabs.length]
  else if (event.key === "Home") next = tabs[0]
  else if (event.key === "End") next = tabs[tabs.length - 1]

  if (!next) return

  event.preventDefault()
  activateTab(next)
  next.focus()
}

function closeMenus(except?: Element | null): void {
  document.querySelectorAll<HTMLDetailsElement>(`${MENU}[open]`).forEach((menu) => {
    if (menu !== except) menu.open = false
  })
}

function onClick(event: MouseEvent): void {
  const target = event.target
  if (!(target instanceof Element)) {
    closeMenus()
    return
  }

  const alertButton = target.closest('[data-dismiss="alert"]')
  if (alertButton) {
    const callout = alertButton.closest('[data-slot="callout"]')
    if (callout) {
      event.preventDefault()
      callout.remove()
    }
  }

  const trigger = target.closest(MODAL_TRIGGER)
  const dialog = trigger ? dialogFor(trigger) : null
  if (dialog) {
    event.preventDefault()
    openDialog(dialog)
  }

  const dismiss = target.closest('[data-dismiss="modal"]')
  const owner = dismiss?.closest("dialog")
  if (owner) {
    event.preventDefault()
    closeDialog(owner)
  }

  if (target instanceof HTMLDialogElement && target.open && isBackdropClick(target, event)) closeDialog(target)

  const tab = target.closest<HTMLElement>(TAB)
  if (tab && tab.closest('[role="tablist"]') && !tab.hasAttribute("disabled")) {
    event.preventDefault()
    activateTab(tab)
  }

  const menu = target.closest(MENU)
  if (menu && target.closest('[role="menuitem"]')) closeMenus()
  else closeMenus(menu)
}

function onKeyDown(event: KeyboardEvent): void {
  const target = event.target
  if (!(target instanceof HTMLElement)) return

  const tab = target.closest<HTMLElement>(TAB)
  if (tab && tab.closest('[role="tablist"]')) {
    onTabKey(tab, event)
    return
  }

  if (event.key === "Escape") {
    const menu = target.closest<HTMLDetailsElement>(`${MENU}[open]`)
    if (menu) {
      menu.open = false
      menu.querySelector("summary")?.focus()
    }
  }
}

/** The dialog's `close` event doesn't bubble, so it's caught on the way down. */
function onClose(event: Event): void {
  if (event.target instanceof HTMLDialogElement) setState(event.target)
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("click", onClick)
    document.addEventListener("keydown", onKeyDown)
    document.addEventListener("close", onClose, true)
    listening = true
  }

  all<HTMLDialogElement>(root, "dialog.forms-dialog").forEach((dialog) => {
    if (once(dialog, "dialog")) setState(dialog)
  })
}
