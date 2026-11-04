import { describe, expect, it, vi } from "vitest"

import { enhance, init, optionsFor } from "../../resources/js/dates"
import { clearDate } from "../../resources/js/inputs"
import { $, html } from "./helpers"

type Picker = HTMLInputElement & { _flatpickr?: ReturnType<typeof enhance> }

const input = (selector: string) => $<Picker>(selector)

describe("date pickers", () => {
  it("enhances date inputs with the server's format", () => {
    html(`<input id="d" type="date" class="date-picker" value="2024-03-05">`)
    init()
    init()

    const picker = input("#d")._flatpickr!
    expect(picker).toBeDefined()
    expect(input("#d").type).toBe("text")
    expect(input("#d").getAttribute("data-forms-type")).toBe("date")
    expect(picker.config.dateFormat).toBe("Y-m-d")
    expect(picker.config.allowInput).toBe(true)
    expect(picker.config.enableTime).toBe(false)
    expect(picker.selectedDates[0]?.getDate()).toBe(5)

    picker.setDate("2024-12-31", true)
    expect(input("#d").value).toBe("2024-12-31")
    expect(enhance(input("#d"))).toBe(picker)
  })

  it("enhances datetime and time inputs", () => {
    html(`<input id="dt" type="datetime" class="datetime-picker" value="2024-03-05 14:30">
      <input id="t" type="time" class="time-picker" value="09:15">`)
    init()

    const datetime = input("#dt")._flatpickr!
    expect(datetime.config.dateFormat).toBe("Y-m-d H:i")
    expect(datetime.config.enableTime).toBe(true)
    expect(datetime.selectedDates[0]?.getHours()).toBe(14)

    const time = input("#t")._flatpickr!
    expect(time.config.dateFormat).toBe("H:i")
    expect(time.config.noCalendar).toBe(true)
    expect(input("#t").value).toBe("09:15")
  })

  it("speaks Dhivehi and lays out right to left", () => {
    document.documentElement.setAttribute("lang", "dv")
    html(`<div dir="rtl"><input id="d" class="date-picker" value="2024-01-15"></div>`)
    init()

    const picker = input("#d")._flatpickr!
    expect(picker.l10n.months.longhand[0]).toBe("ޖެނުއަރީ")
    expect(picker.l10n.weekdays.longhand[5]).toBe("ހުކުރު")
    expect(picker.calendarContainer.getAttribute("dir")).toBe("rtl")
    expect(picker.calendarContainer.classList.contains("forms-flatpickr")).toBe(true)
    expect(optionsFor(input("#d")).position).toBe("auto right")
  })

  it("stays in English left to right otherwise", () => {
    html(`<input id="d" class="date-picker">`)
    const picker = enhance(input("#d"))
    expect(picker.l10n.months.longhand[0]).toBe("January")
    expect(picker.calendarContainer.getAttribute("dir")).toBe("ltr")
    expect(optionsFor(input("#d")).position).toBe("auto")
  })

  it("keeps the calendar inside dialogs and positions it on the input group", () => {
    html(`<dialog><div data-slot="input-group" id="g"><input id="d" class="date-picker"></div></dialog>`)
    const options = optionsFor(input("#d"))
    expect(options.static).toBe(true)
    expect(options.positionElement).toBe($("#g"))
  })

  it("reads min and max", () => {
    html(`<input id="d" class="date-picker" min="2024-01-01" max="2024-12-31">`)
    const options = optionsFor(input("#d"))
    expect(options.minDate).toBe("2024-01-01")
    expect(options.maxDate).toBe("2024-12-31")
  })

  it("clears through the clear button", () => {
    html(`<input id="d" class="date-picker" value="2024-03-05">`)
    init()
    const change = vi.fn()
    input("#d").addEventListener("change", change)

    clearDate(input("#d"))
    expect(input("#d").value).toBe("")
    expect(input("#d")._flatpickr!.selectedDates).toHaveLength(0)
    expect(change).toHaveBeenCalled()
  })
})
