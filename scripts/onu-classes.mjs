// Extracts the class strings @javaabu/onu renders, so the Blade `onu` views output
// exactly the same classes as the React components.
//
// It server-renders Onu's own components and records the classes of every element
// with a data-slot, then writes resources/onu/classes.php. Run with `pnpm onu-classes`
// after upgrading @javaabu/onu; CI fails when the file is out of date (`pnpm onu-classes --check`).
import { readFileSync, writeFileSync } from "node:fs"
import { createRequire } from "node:module"
import { createElement as h } from "react"
import { renderToStaticMarkup } from "react-dom/server"
import * as Onu from "@javaabu/onu"
import * as P from "@javaabu/onu/primitives"

const require = createRequire(import.meta.url)
const { version } = require("@javaabu/onu/package.json")
const OUT = "resources/onu/classes.php"

/** Every data-slot in the HTML → its class attribute (first occurrence wins). */
function slots(html) {
  const found = {}
  for (const match of html.matchAll(/<([a-z0-9]+)\b([^>]*)>/g)) {
    const attrs = match[2]
    const slot = attrs.match(/\bdata-slot="([^"]+)"/)?.[1]
    if (!slot || slot in found) continue
    found[slot] = decode(attrs.match(/\bclass="([^"]*)"/)?.[1] ?? "")
  }
  return found
}

function decode(value) {
  return value
    .replaceAll("&amp;", "&")
    .replaceAll("&gt;", ">")
    .replaceAll("&lt;", "<")
    .replaceAll("&quot;", '"')
    .replaceAll("&#x27;", "'")
}

const render = (element) => slots(renderToStaticMarkup(element))

/** Classes of every element in order, for wrappers that have no data-slot. */
function tags(element) {
  return [...renderToStaticMarkup(element).matchAll(/<([a-z0-9]+)\b([^>]*)>/g)].map((match) => ({
    tag: match[1],
    slot: match[2].match(/\bdata-slot="([^"]+)"/)?.[1],
    class: decode(match[2].match(/\bclass="([^"]*)"/)?.[1] ?? ""),
  }))
}

/** The class of the first element after the given slot (or from the start) matching the tag. */
function after(list, slot, tag, nth = 1) {
  let index = slot ? list.findIndex((item) => item.slot === slot) : -1
  let seen = 0
  for (index += 1; index < list.length; index++) {
    if (list[index].tag === tag && ++seen === nth) return list[index].class
  }
  throw new Error(`No <${tag}> #${nth} after ${slot}`)
}
const option = (value, label) => h("option", { value }, label)

const classes = {}

// Fields: label, required marker, help, errors, stacked and inline layouts.
classes.field = render(h(Onu.FormField, { label: "Title", name: "title", help: "Help", required: true }, h(Onu.TextInput, { name: "title" })))
classes.field_invalid = render(h(Onu.FormField, { label: "Title", name: "title", error: "Required" }, h(Onu.TextInput, { name: "title" })))
classes.field_inline = render(h(Onu.FormField, { label: "Title", name: "title", labelLayout: "inline" }, h(Onu.TextInput, { name: "title" })))

for (const [key, layout] of [["field", "stacked"], ["field_inline", "inline"]]) {
  const list = tags(h(Onu.FormField, { label: "Title", name: "title", labelLayout: layout, error: "Required" }, h(Onu.TextInput, { name: "title" })))
  classes[key].grid = after(list, "form-field", "div", 1)
  classes[key].label_row = after(list, "form-field", "div", 2)
  classes[key].control = after(list, "label", "div", 1)
  classes[key].error_line = after(list, "field-errors", "p", 1)
  classes[key].error_icon = after(list, "field-errors", "svg", 1).replace(/lucide\S*\s?/g, "").trim()
}

// Controls
classes.input = render(h(P.Input, { name: "title" }))
classes.input_group_text = after(tags(h(P.InputGroup, null, h(P.InputGroupAddon, null, h(P.InputGroupText, null, "MVR")))), "input-group-addon", "span", 1)
classes.input_group = render(
  h(P.InputGroup, null, h(P.InputGroupAddon, null, h(P.InputGroupText, null, "MVR")), h(P.InputGroupInput, { name: "price" }), h(P.InputGroupAddon, { align: "inline-end" }, h(P.InputGroupButton, null, "Clear"))),
)
classes.textarea = render(h(P.Textarea, { name: "body" }))
classes.select = render(h(P.NativeSelect, { name: "status" }, h(P.NativeSelectOption, { value: "" }, "A")))
classes.checkbox = render(h(P.Checkbox, { checked: true }))
classes.radio = render(h(P.RadioGroup, { defaultValue: "a" }, h(P.RadioGroupItem, { value: "a" })))
// Onu's checkbox and radio are Radix buttons; Blade uses native inputs with the same classes,
// with the checked state from :checked instead of data-state.
const native = (value) =>
  `appearance-none ${value}`.replaceAll("data-[state=checked]:", "checked:").replaceAll("data-checked:", "checked:").replaceAll("aria-checked:", "checked:")
classes.checkbox.native = native(classes.checkbox.checkbox)
classes.radio.native = native(classes.radio["radio-group-item"])
classes.choice = render(h(Onu.Checkbox, { label: "Agree", description: "Help", name: "agree" }))
{
  const list = tags(h(Onu.Checkbox, { label: "Agree", description: "Help", name: "agree" }))
  classes.choice.control = after(list, "checkbox-field", "span", 1)
  classes.choice.content = after(list, "checkbox", "div", 1)
  classes.choice.description = after(list, "label", "p", 1)
}
classes.label = render(h(P.Label, null, "Title"))

// Buttons: every variant x size.
const variants = ["default", "outline", "dashed", "secondary", "ghost", "destructive", "link", "success", "warning"]
const sizes = ["default", "xs", "sm", "lg", "icon", "icon-xs", "icon-sm", "icon-lg"]
classes.button = Object.fromEntries(variants.map((variant) => [variant, Object.fromEntries(sizes.map((size) => [size, Onu.buttonVariants({ variant, size })]))]))
classes.button_group = render(h(Onu.ButtonGroup, null, h(Onu.Button, null, "A")))
classes.spinner = render(h(Onu.Button, { loading: true }, "Saving"))

// Status badges and alerts, by tone.
const tones = ["neutral", "info", "success", "warning", "danger"]
classes.status = Object.fromEntries(["neutral", "info", "success", "warning", "danger", "pending"].map((tone) => [tone, Onu.statusBadgeVariants({ tone })]))
classes.alert = Object.fromEntries(
  tones.map((tone) => [tone, render(h(Onu.Callout, { tone, title: "Heading", dismissible: true }, "Body"))]),
)

// Display
classes.card = render(
  h(P.Card, null, h(P.CardHeader, null, h(P.CardTitle, null, "Title"), h(P.CardDescription, null, "Subtitle")), h(P.CardContent, null, "Body"), h(P.CardFooter, null, "Footer")),
)
classes.accordion = render(
  h(P.Accordion, { type: "single", defaultValue: "a", collapsible: true }, h(P.AccordionItem, { value: "a" }, h(P.AccordionTrigger, null, "Title"), h(P.AccordionContent, null, "Body"))),
)
classes.tabs = render(
  h(P.Tabs, { defaultValue: "a" }, h(P.TabsList, null, h(P.TabsTrigger, { value: "a" }, "A"), h(P.TabsTrigger, { value: "b" }, "B")), h(P.TabsContent, { value: "a" }, "Body")),
)
const navTabs = h(Onu.NavTabs, { items: [{ label: "Active", href: "/a", count: 3 }, { label: "Other", href: "/b" }], currentHref: "/a" })
classes.nav_tabs = render(navTabs)
classes.nav_tabs.list = after(tags(navTabs), "nav-tabs", "ul", 1)
classes.nav_tabs.item = after(tags(navTabs), "nav-tabs", "li", 1)
classes.modal = {
  ...render(h(P.Dialog, { open: true }, h(Onu.ModalHeader, null, h(Onu.ModalTitle, null, "Title")), h(Onu.ModalBody, null, "Body"), h(Onu.ModalFooter, null, "Footer"))),
  sizes: Object.fromEntries(["sm", "default", "lg", "xl", "full"].map((size) => [size, Onu.modalContentVariants({ size })])),
}
classes.table = render(
  h(P.Table, null, h(P.TableHeader, null, h(P.TableRow, null, h(P.TableHead, null, "No"))), h(P.TableBody, null, h(P.TableRow, null, h(P.TableCell, null, "1")))),
)
classes.pagination = render(
  h(
    P.Pagination,
    null,
    h(
      P.PaginationContent,
      null,
      h(P.PaginationItem, null, h(P.PaginationPrevious, { href: "#" })),
      h(P.PaginationItem, null, h(P.PaginationLink, { href: "#", isActive: true }, "1")),
      h(P.PaginationItem, null, h(P.PaginationLink, { href: "#" }, "2")),
      h(P.PaginationItem, null, h(P.PaginationEllipsis)),
      h(P.PaginationItem, null, h(P.PaginationNext, { href: "#" })),
    ),
  ),
)
classes.pagination.link = render(h(P.PaginationLink, { href: "#" }, "2"))["pagination-link"]
classes.pagination.link_active = render(h(P.PaginationLink, { href: "#", isActive: true }, "1"))["pagination-link"]
classes.pagination.previous = render(h(P.PaginationPrevious, { href: "#" }))["pagination-link"]
classes.pagination.next = render(h(P.PaginationNext, { href: "#" }))["pagination-link"]
classes.empty = render(
  h(P.Empty, null, h(P.EmptyHeader, null, h(P.EmptyMedia, { variant: "icon" }, "i"), h(P.EmptyTitle, null, "Title"), h(P.EmptyDescription, null, "Text")), h(P.EmptyContent, null, "Action")),
)
classes.description_list = {
  stacked: render(h(Onu.DescriptionList, { layout: "stacked" }, h(Onu.DescriptionListItem, { label: "Name" }, "Value"))),
  inline: render(h(Onu.DescriptionList, { layout: "inline" }, h(Onu.DescriptionListItem, { label: "Name" }, "Value"))),
}
classes.badge = render(h(P.Badge, null, "3"))

// PHP output
function php(value, indent = 1) {
  const pad = "    ".repeat(indent)
  if (typeof value === "string") return `'${value.replaceAll("\\", "\\\\").replaceAll("'", "\\'")}'`
  const entries = Object.entries(value).map(([key, item]) => `${pad}'${key}' => ${php(item, indent + 1)},`)
  return `[\n${entries.join("\n")}\n${"    ".repeat(indent - 1)}]`
}

const output = `<?php

/*
 * Class strings rendered by @javaabu/onu v${version}, keyed by component and data-slot.
 * Generated by scripts/onu-classes.mjs; don't edit by hand. Run \`pnpm onu-classes\` after upgrading Onu.
 */

return ${php(classes)};
`

if (process.argv.includes("--check")) {
  const current = readFileSync(OUT, "utf8")
  if (current !== output) {
    console.error(`${OUT} is out of date with @javaabu/onu v${version}. Run \`pnpm onu-classes\` and review the view changes.`)
    process.exit(1)
  }
  console.log(`${OUT} matches @javaabu/onu v${version}`)
} else {
  writeFileSync(OUT, output)
  console.log(`Wrote ${OUT} from @javaabu/onu v${version}`)
}
