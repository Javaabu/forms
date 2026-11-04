/**
 * Conditional display: enable, disable, show and hide fields based on another
 * field's value. A port of js-utilities' conditional-display.js.
 *
 * - `[data-enable-elem="#type"][data-enable-section-value="value"]` enables the
 *   section's fields when `#type` has the value (or one of a JSON array of values).
 * - `[data-enable-section-checkbox="#checkbox"]` enables them when the checkbox is checked.
 * - On either: `data-disable` inverts it, `data-hide-fields` also hides the section.
 * - `[data-toggle-checkbox="#fields"]` (on a checkbox) disables the fields while checked.
 * - `[data-enable-checkbox="#fields"]` (on a checkbox) enables and shows them while
 *   checked (`data-disable` inverts it).
 * - `[data-disable-on-select="#fields"]` (on a select) disables them while it has a value
 *   (`data-hide-fields` also hides them).
 *
 * Fields disabled here get the `auto-disabled` class, and only those are enabled again,
 * so fields disabled by the server stay disabled. Hiding uses the `hidden` attribute.
 */
import {
  all,
  autoDisable,
  autoEnable,
  currentValue,
  data,
  flag,
  isBlank,
  once,
  picks,
  select,
  valueOf,
  type FormControl,
} from "./dom"

const SECTION_VALUE = "[data-enable-elem][data-enable-section-value]"
const SECTION_CHECKBOX = "[data-enable-section-checkbox]"
const TOGGLE_CHECKBOX = "[data-toggle-checkbox]"
const ENABLE_CHECKBOX = "[data-enable-checkbox]"
const DISABLE_ON_SELECT = "[data-disable-on-select]"

/** Enables (only auto-disabled) or disables (only enabled) the `tags` inside `container`, and hides it if asked. */
function toggleFields(container: HTMLElement, enable: boolean, tags: string[], hide: boolean): void {
  if (enable) {
    const selector = tags.map((tag) => `${tag}.auto-disabled:disabled`).join(", ")
    container.querySelectorAll<FormControl>(selector).forEach(autoEnable)
  } else {
    const selector = tags.map((tag) => `${tag}:enabled`).join(", ")
    container.querySelectorAll<FormControl>(selector).forEach(autoDisable)
  }

  if (hide) container.hidden = !enable
}

function isChecked(el: Element): boolean {
  return el instanceof HTMLInputElement && el.checked
}

function matches(current: string | string[], expected: unknown): boolean {
  const wanted = (Array.isArray(expected) ? expected : [expected]).map((value) => String(value ?? ""))
  const values = Array.isArray(current) ? current : [current]

  return values.some((value) => wanted.includes(value))
}

function applySectionValue(section: HTMLElement): void {
  const controls = select(section.getAttribute("data-enable-elem"))
  if (!controls.length) return

  const matching = matches(currentValue(controls), data(section, "enable-section-value"))
  const enable = flag(section, "disable") ? !matching : matching

  toggleFields(section, enable, ["select", "input", "textarea"], flag(section, "hide-fields"))
}

function applySectionCheckbox(section: HTMLElement): void {
  const checkboxes = select(section.getAttribute("data-enable-section-checkbox"))
  if (!checkboxes.length) return

  const matching = checkboxes.some(isChecked)
  const enable = flag(section, "disable") ? !matching : matching

  toggleFields(section, enable, ["select", "input", "textarea", "button"], flag(section, "hide-fields"))
}

function applyToggleCheckbox(checkbox: HTMLElement): void {
  const checked = isChecked(checkbox)

  select<FormControl>(checkbox.getAttribute("data-toggle-checkbox")).forEach((field) => {
    field.disabled = checked
  })
}

function applyEnableCheckbox(checkbox: HTMLElement): void {
  const checked = isChecked(checkbox)
  const enable = flag(checkbox, "disable") ? !checked : checked

  select(checkbox.getAttribute("data-enable-checkbox")).forEach((fields) =>
    toggleFields(fields, enable, ["select", "input"], true),
  )
}

function applyDisableOnSelect(control: HTMLElement): void {
  const disable = !isBlank(valueOf(control))
  const hide = flag(control, "hide-fields")

  select(control.getAttribute("data-disable-on-select")).forEach((fields) =>
    toggleFields(fields, !disable, ["select", "input"], hide),
  )
}

function onChange(event: Event): void {
  const target = event.target
  if (!(target instanceof HTMLElement)) return

  if (target.matches(TOGGLE_CHECKBOX)) applyToggleCheckbox(target)
  if (target.matches(ENABLE_CHECKBOX)) applyEnableCheckbox(target)
  if (target.matches(DISABLE_ON_SELECT)) applyDisableOnSelect(target)

  document.querySelectorAll<HTMLElement>(SECTION_VALUE).forEach((section) => {
    if (picks(section.getAttribute("data-enable-elem"), target)) applySectionValue(section)
  })

  document.querySelectorAll<HTMLElement>(SECTION_CHECKBOX).forEach((section) => {
    if (picks(section.getAttribute("data-enable-section-checkbox"), target)) applySectionCheckbox(section)
  })
}

let listening = false

export function init(root: ParentNode = document): void {
  if (!listening) {
    document.addEventListener("change", onChange)
    listening = true
  }

  const rules: [string, string, (el: HTMLElement) => void][] = [
    ["toggle-checkbox", TOGGLE_CHECKBOX, applyToggleCheckbox],
    ["enable-checkbox", ENABLE_CHECKBOX, applyEnableCheckbox],
    ["section-checkbox", SECTION_CHECKBOX, applySectionCheckbox],
    ["section-value", SECTION_VALUE, applySectionValue],
    ["disable-on-select", DISABLE_ON_SELECT, applyDisableOnSelect],
  ]

  for (const [name, selector, apply] of rules) {
    all(root, selector).forEach((el) => {
      if (once(el, name)) apply(el)
    })
  }
}
