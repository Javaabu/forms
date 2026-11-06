/**
 * javaabu/forms core behaviours, for both the Onu and Bootstrap 6 views:
 * conditional display, select all, date clear buttons, the submit spinner, focus
 * on error, Thaana input, auto-resizing textareas, decimal rounding, sortable
 * table headings, and the Onu alerts, dialogs, tabs and menus.
 *
 * Loaded as a script it enhances the page by itself, and anything added later.
 * With a bundler: `import { init } from "@javaabu/forms-blade/forms"` and call `init(root)`.
 */
import * as conditional from "./conditional"
import { autoInit } from "./dom"
import * as inputs from "./inputs"
import * as selectAll from "./select-all"
import * as sortable from "./sortable"
import * as submit from "./submit"
import * as thaana from "./thaana"
import * as widgets from "./widgets"

export function init(root: ParentNode = document): void {
  conditional.init(root)
  selectAll.init(root)
  sortable.init(root)
  inputs.init(root)
  submit.init(root)
  thaana.init(root)
  widgets.init(root)
}

export { conditional, inputs, selectAll, sortable, submit, thaana, widgets }

autoInit(init)
