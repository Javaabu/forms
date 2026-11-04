/**
 * Thaana: `[data-thaana]` inputs and textareas type Thaana from a Latin keyboard,
 * with Onu's keyboard (phonetic layout, Alt+Shift+T toggles it). The keymap can be
 * changed per field with `data-thaana-keymap="phonetic" | "phonetic-hh" | "typewriter"`.
 */
import { attachThaanaKeyboard, type KeymapName, type ThaanaKeyboardController } from "@javaabu/onu/thaana"

import { all, once } from "./dom"

const KEYMAPS: readonly string[] = ["phonetic", "phonetic-hh", "typewriter"]

const controllers = new WeakMap<HTMLElement, ThaanaKeyboardController>()

/** The keyboard attached to a field, to turn it off or change its keymap. */
export function controllerFor(el: HTMLElement): ThaanaKeyboardController | undefined {
  return controllers.get(el)
}

export function init(root: ParentNode = document): void {
  all<HTMLInputElement | HTMLTextAreaElement>(root, "input[data-thaana], textarea[data-thaana]").forEach((field) => {
    if (!once(field, "thaana")) return

    const keymap = field.getAttribute("data-thaana-keymap") ?? ""

    controllers.set(
      field,
      attachThaanaKeyboard(field, KEYMAPS.includes(keymap) ? { keymap: keymap as KeymapName } : {}),
    )
  })
}
