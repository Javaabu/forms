/**
 * Dhivehi (`dv`) locale for flatpickr, which ships none. The month and day names
 * are the ones @javaabu/onu uses in its Dhivehi date-fns locale.
 */
import type { CustomLocale } from "flatpickr/dist/types/locale"

const months: CustomLocale["months"]["longhand"] = [
  "ޖެނުއަރީ",
  "ފެބްރުއަރީ",
  "މާޗު",
  "އެޕްރީލް",
  "މެއި",
  "ޖޫން",
  "ޖުލައި",
  "އޮގަސްޓު",
  "ސެޕްޓެމްބަރު",
  "އޮކްޓޯބަރު",
  "ނޮވެމްބަރު",
  "ޑިސެމްބަރު",
]

export function dhivehi(): CustomLocale {
  return {
    weekdays: {
      shorthand: ["އާދި", "ހޯމަ", "އަން", "ބުދަ", "ބުރާ", "ހުކު", "ހޮނި"],
      longhand: ["އާދިއްތަ", "ހޯމަ", "އަންގާރަ", "ބުދަ", "ބުރާސްފަތި", "ހުކުރު", "ހޮނިހިރު"],
    },
    months: { shorthand: months, longhand: months },
    firstDayOfWeek: 0,
    rangeSeparator: " - ",
    weekAbbreviation: "ހަފްތާ",
    scrollTitle: "",
    toggleTitle: "",
    amPM: ["މކ", "މފ"],
    yearAriaLabel: "އަހަރު",
    monthAriaLabel: "މަސް",
    hourAriaLabel: "ގަޑި",
    minuteAriaLabel: "މިނެޓު",
    time_24hr: false,
    ordinal: () => "",
  }
}
