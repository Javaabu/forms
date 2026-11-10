/**
 * Date and time pickers with flatpickr, a port of js-utilities' date-input.js.
 *
 * `input.date-picker` (`Y-m-d`), `input.datetime-picker` (`Y-m-d H:i`) and
 * `input.time-picker` (`H:i`), the formats the server renders. Typing is allowed.
 * The calendar is in Dhivehi when `<html lang="dv">`, and right to left when the
 * input is. `min`/`max` attributes limit the dates.
 */
import flatpickr from "flatpickr"
import type { Instance } from "flatpickr/dist/types/instance"
import type { Options } from "flatpickr/dist/types/options"

import { all, autoInit, isRtl, once } from "./dom"
import { dhivehi } from "./flatpickr-dv"
import { getLocale } from "./i18n"

export { flatpickr }

export const SELECTOR = "input.date-picker, input.datetime-picker, input.time-picker"

const CHEVRON = (path: string): string =>
  `<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="${path}"/></svg>`

const PREV = CHEVRON("m15 18-6-6 6-6")
const NEXT = CHEVRON("m9 18 6-6-6-6")

type Kind = "date" | "datetime" | "time"

function kindOf(input: HTMLInputElement): Kind {
  if (input.classList.contains("datetime-picker")) return "datetime"
  if (input.classList.contains("time-picker")) return "time"

  return "date"
}

/** flatpickr options for an input, from its class and attributes. */
export function optionsFor(input: HTMLInputElement): Partial<Options> {
  const kind = kindOf(input)
  const rtl = isRtl(input)
  const dialog = input.closest("dialog")

  const options: Partial<Options> = {
    allowInput: true,
    enableTime: kind !== "date",
    noCalendar: kind === "time",
    dateFormat: kind === "datetime" ? "Y-m-d H:i" : kind === "time" ? "H:i" : "Y-m-d",
    prevArrow: PREV,
    nextArrow: NEXT,
    position: rtl ? "auto right" : "auto",
    // Inside a modal <dialog> (the top layer), the calendar must be too.
    static: !!dialog,
    positionElement: input.closest<HTMLElement>('[data-slot="input-group"], .input-group') ?? (input as HTMLElement),
    onReady: (_dates: Date[], _value: string, instance: Instance) => {
      instance.calendarContainer.setAttribute("dir", rtl ? "rtl" : "ltr")
      instance.calendarContainer.classList.add("forms-flatpickr")
    },
  }

  if (getLocale().split("_")[0] === "dv") options.locale = dhivehi()

  if (input.min) options.minDate = input.min
  if (input.max) options.maxDate = input.max

  return options
}

export function enhance(input: HTMLInputElement): Instance {
  const existing = (input as HTMLInputElement & { _flatpickr?: Instance })._flatpickr
  if (existing) return existing

  // A native date or time input would show its own picker too.
  if (["date", "time", "datetime-local", "datetime"].includes(input.type)) {
    input.setAttribute("data-forms-type", input.type)
    input.type = "text"
  }

  return flatpickr(input, optionsFor(input)) as Instance
}

export function init(root: ParentNode = document): void {
  all<HTMLInputElement>(root, SELECTOR).forEach((input) => {
    if (once(input, "dates")) enhance(input)
  })
}

autoInit(init)
