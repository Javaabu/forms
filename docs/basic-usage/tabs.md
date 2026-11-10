---
title: Tabs and nav tabs
sidebar_position: 18
---

# Tabs and nav tabs

- `<x-forms::tabs>` shows one panel at a time on the same page.
- `<x-forms::nav-tabs>` is a row of links between pages, styled as tabs.

## Tabs

List the tabs and put each panel in a slot named after the tab:

```blade
@php
    $tabs = [
        ['name' => 'details', 'title' => 'ތަފްޞީލް'],
        ['name' => 'documents', 'title' => __('Documents')],
        ['name' => 'history', 'title' => __('History'), 'disabled' => true],
        ['name' => 'help', 'title' => __('Help'), 'url' => route('help')],
    ];
@endphp

<x-forms::tabs :tabs="$tabs" active="documents">
    <x-slot:details>
        <x-forms::text name="name" label="ނަން" />
    </x-slot:details>

    <x-slot:documents>
        <x-forms::file name="cv" />
    </x-slot:documents>
</x-forms::tabs>
```

Each tab takes:

| Key | Default | Description |
| --- | --- | --- |
| `name` | required | Tab name. The panel's slot is its kebab case (`personal_info` → `<x-slot:personal-info>`), and the panel's `id` is the name. |
| `title` | from `name` | Tab text. Generated from the name and translated, like field labels. |
| `url` | none | Makes the tab a link to another page instead of a panel. |
| `disabled` | `false` | The tab can't be selected. |

- `active` is the name of the tab that starts selected. It defaults to the first tab.
- A tab without a slot has no panel.
- `tabs` can be an array or a `Collection`.

Fields in hidden panels are still submitted with the form.

### Switching tabs

- `onu`: the tabs are `<button role="tab">` with `data-tab-target`, and the package's script switches panels on click and with the arrow keys (reversed in right-to-left pages), Home and End. See [Assets](../advanced-usage/assets.md).
- `bootstrap-6`: the tabs use `data-bs-toggle="tab"`, handled by Bootstrap's JavaScript.

### Opening a tab after validation fails

Pick the active tab from the errors, so the user sees the invalid field:

```blade
<x-forms::tabs :tabs="$tabs" :active="$errors->has('cv') ? 'documents' : 'details'">
    …
</x-forms::tabs>
```

### Tab parts

`tabs.nav-item` and `tabs.pane` render one tab and one panel. `tabs` uses them; use them directly for custom tab markup. Keep the ids matching:

- The nav item's `name` is its id (`details-tab`), and its `target` is the pane's `name` (`details`).
- The pane is labelled by `{name}-tab` unless you set `labelled-by`.
- In `onu`, put nav items in an element with `role="tablist"`; in `bootstrap-6`, in a `ul.nav.nav-tabs` (each nav item is an `<li>`).

```blade
<div role="tablist">
    <x-forms::tabs.nav-item name="details-tab" target="details" :title="__('Details')" is-tab active />
</div>

<x-forms::tabs.pane name="details" active>
    …
</x-forms::tabs.pane>
```

## Nav tabs

```blade
@php
    $sections = [
        ['title' => 'ތަފްޞީލް', 'url' => route('applications.show', $application), 'active' => request()->routeIs('applications.show')],
        ['title' => __('Documents'), 'url' => route('applications.documents', $application), 'icon' => 'file-text', 'count' => $documents_count],
        ['title' => __('Payments'), 'url' => '#', 'disabled' => true],
    ];
@endphp

<x-forms::nav-tabs :tabs="$sections" />
```

Each tab takes:

| Key | Default | Description |
| --- | --- | --- |
| `title` | required | Link text. |
| `url` | `'#'` | Link URL. |
| `active` | `false` | Marks the current page (`aria-current="page"`). |
| `disabled` | `false` | Shown as disabled. |
| `icon` | none | Icon before the title: a [Lucide name or icon font classes](./icons.md). |
| `count` | none | A number after the title. |

In `onu` the links are in a `<nav aria-label="Sections">` (translated); in `bootstrap-6` they're a `ul.nav.nav-tabs`, with the count in a badge.

## Attributes

### `tabs`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `tabs` | `array` or `Collection` | `[]` | Tabs. See [Tabs](#tabs). |
| `active` | `string` | first tab | Name of the selected tab. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slots: one per tab, named after it.

### `tabs.nav-item`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `title` | `string` | required | Tab text. The slot replaces it. |
| `name` | `string` | `''` | Gives the tab's `id`. |
| `target` | `string` | `''` | Id of the panel, without `#`. |
| `url` | `string` | `'#'` | Link URL when it isn't a tab. |
| `is-tab` | `bool` | `false` | Renders a tab button for a panel instead of a link. |
| `active` | `bool` | `false` | Selected. |
| `disabled` | `bool` | `false` | Disabled. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `tabs.pane`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Panel id. |
| `labelled-by` | `string` | `{name}-tab` | Id of the tab that labels the panel. |
| `active` | `bool` | `false` | Shown. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `nav-tabs`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `tabs` | `array` or `Collection` | `[]` | Links. See [Nav tabs](#nav-tabs). |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

## React

```jsx
import { Tabs, NavTabs } from "@javaabu/forms"

<Tabs tabs={tabs} active="documents" details={<Text name="name" label="ނަން" />} />
<NavTabs tabs={sections} />
```

Named slots are props of the same name. `TabsPane` is React's `tabs.pane`; `tabs.nav-item` and `labelled-by` are Blade only. See [Parity](../parity.md).
