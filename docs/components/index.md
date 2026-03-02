---
title: Component Index
description: Complete index of all components in the Javaabu Forms package
category: components
order: 0
---

# Component Index

This page provides a complete index of all components available in the Javaabu Forms package.

## Table of Contents

- [Base Components](#base-components)
- [Input Components](#input-components)
- [Date & Time Components](#date--time-components)
- [Map & Location Components](#map--location-components)
- [File & Image Components](#file--image-components)
- [Select Components](#select-components)
- [Control Components](#control-components)
- [Layout Components](#layout-components)
- [Feedback Components](#feedback-components)
- [Navigation Components](#navigation-components)
- [Utility Components](#utility-components)

---

## Base Components

Foundation components that serve as building blocks for other form elements and UI components.

- [Component](./base-components.md#component)
- [FormGroup](./base-components.md#formgroup)
- [Form](./base-components.md#form)
- [FormOpen](./base-components.md#formopen)
- [FormClose](./base-components.md#formclose)
- [Label](./base-components.md#label)
- [LabelRequired](./base-components.md#labelrequired)
- [InputHelp](./base-components.md#inputhelp)
- [Errors](./base-components.md#errors)
- [JsErrors](./base-components.md#jserrors)
- [Wysiwyg](./base-components.md#wysiwyg)
- [Hidden](./base-components.md#hidden)

---

## Input Components

Standard input field components for various input types.

- [Input](./input-components.md#input)
- [Text](./input-components.md#text)
- [Email](./input-components.md#email)
- [Password](./input-components.md#password)
- [Tel](./input-components.md#tel)
- [Url](./input-components.md#url)
- [Number](./input-components.md#number)
- [Textarea](./input-components.md#textarea)
- [Checkbox](./input-components.md#checkbox)
- [Radio](./input-components.md#radio)
- [BooleanEntry](./input-components.md#booleanentry)
- [TextEntry](./input-components.md#textentry)

---

## Date & Time Components

Date and time selection components.

- [Date](./date-time-components.md#date)
- [Datetime](./date-time-components.md#datetime)
- [Time](./date-time-components.md#time)

---

## Map & Location Components

Map and location-related input components.

- [MapInput](./map-location-components.md#mapinput)
- [Latitude](./map-location-components.md#latitude)
- [Longitude](./map-location-components.md#longitude)

---

## File & Image Components

File upload and image management components.

- [File](./file-image-components.md#file)
- [Image](./file-image-components.md#image)
- [FileUpload](./file-image-components.md#fileupload)
- [ImageUpload](./file-image-components.md#imageupload)

---

## Select Components

Dropdown selection components including Select2.

- [Select](./select-components.md#select)
- [Select2](./select-components.md#select2)

---

## Control Components

Button and control components.

- [Button](./control-components.md#button)
- [Submit](./control-components.md#submit)
- [LinkButton](./control-components.md#linkbutton)
- [ButtonGroup](./control-components.md#buttongroup)

---

## Layout Components

Layout components including cards, accordions, tabs, and tables.

### Main Layout Components
- [Card](./layout-components.md#card)
- [Accordion](./layout-components.md#accordion)
- [Tabs](./layout-components.md#tabs)
- [Table](./layout-components.md#table)

### Accordion Components
- [AccordionItem](./layout-components.md#accordionitem)
- [AccordionHeader](./layout-components.md#accordionheader)
- [AccordionCollapse](./layout-components.md#accordioncollapse)

### Card Components
- [CardHeader](./layout-components.md#cardheader)
- [CardTitle](./layout-components.md#cardtitle)
- [CardSubtitle](./layout-components.md#cardsubtitle)
- [CardFooter](./layout-components.md#cardfooter)

### Tabs Components
- [TabsNavItem](./layout-components.md#tabsnavitem)
- [TabsPane](./layout-components.md#tabspane)

### Table Components
- [TableHeading](./layout-components.md#tableheading)
- [TableRow](./layout-components.md#tablerow)
- [TableCell](./layout-components.md#tablecell)
- [TableEmptyRow](./layout-components.md#tableemptyrow)

---

## Feedback Components

Alerts, status indicators, and no items displays.

- [Alert](./feedback-components.md#alert)
- [Status](./feedback-components.md#status)
- [NoItems](./feedback-components.md#noitems)

---

## Navigation Components

Navigation tab components.

- [NavTabs](./navigation-components.md#navtabs)

---

## Utility Components

Utility components including search forms, filters, and bulk actions.

- [Infolist](./utility-components.md#infolist)
- [SearchForm](./utility-components.md#searchform)
- [Filter](./utility-components.md#filter)
- [FilterSubmit](./utility-components.md#filtersubmit)
- [PerPage](./utility-components.md#perpage)
- [BulkActions](./utility-components.md#bulkactions)
- [ConditionalLink](./utility-components.md#conditionallink)
- [ConditionalWrapper](./utility-components.md#conditionalwrapper)
- [Modal](./utility-components.md#modal)

---

## Component Categories

### By Purpose
- **Form Controls**: Input, Select, Checkbox, Radio, Textarea, Date, Time, File, etc.
- **Display Components**: Infolist, TextEntry, Status, Alert, NoItems
- **Layout Components**: Card, Accordion, Tabs, Table
- **Navigation Components**: NavTabs
- **Utility Components**: SearchForm, Filter, BulkActions, Modal

### By Component Type
- **Input Components**: All form input fields
- **Output Components**: Infolist, TextEntry
- **Layout Components**: Cards, Accordions, Tabs, Tables
- **Feedback Components**: Alerts, Status indicators
- **Control Components**: Buttons, Submit buttons
- **Utility Components**: Search, Filter, Bulk actions, Modals

---

## Quick Start

### Basic Form
```blade
<x-form method="POST" :model="$user">
    <x-text name="name" label="Name" required />
    <x-email name="email" label="Email" required />
    <x-password name="password" label="Password" required />
    <x-submit>Save Changes</x-submit>
</x-form>
```

### Search Form
```blade
<x-search-form action="/users" placeholder="Search users..." />
```

### Filter Form
```blade
<x-filter>
    <x-slot:item name="search">
        <x-input name="search" label="Search" />
    </x-slot:item>
    <x-slot:item name="status">
        <x-select name="status" :options="$statuses" />
    </x-slot:item>
</x-filter>
```

### Card with Content
```blade
<x-card title="Profile Information">
    <x-slot:header>
        <span class="badge">New</span>
    </x-slot:header>

    <div class="card-body">
        <x-text-entry :model="$user" name="name" :show-label="false" />
        <x-text-entry :model="$user" name="email" :show-label="false" />
    </div>

    <x-slot:footer>
        <x-button>Save Changes</x-button>
    </x-slot:footer>
</x-card>
```

### Table with Data
```blade
<x-table :model="$users" striped>
    <x-slot:heading>
        <x-heading name="name" sortable label="Name" />
        <x-heading name="email" sortable label="Email" />
        <x-heading name="status" sortable label="Status" />
    </x-slot:heading>

    <x-slot:row>
        @foreach($users as $user)
            <x-row :model="$user">
                <x-cell :model="$user" name="name" />
                <x-cell :model="$user" name="email" />
                <x-cell :model="$user" name="status" />
            </x-row>
        @endforeach
    </x-slot:row>
</x-table>
```

---

## Getting Help

- [Installation Guide](../installation-and-setup.md)
- [Basic Usage](../basic-usage/)
- [Form Validation](../basic-usage/validation.md)
- [File Uploads](../basic-usage/file-uploads.md)
- [API Documentation](https://laravel.com/docs/components)

---

## Component Version Support

All components are tested and compatible with:
- Laravel 9.x
- Laravel 10.x
- Laravel 11.x
- Laravel 12.x
- Laravel 13.x

UI Framework Support:
- Bootstrap 5
- Material Admin 26

---

## License

This package is open-sourced software licensed under the [MIT license](../../../LICENSE).
