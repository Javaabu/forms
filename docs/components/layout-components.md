---
title: Layout Components
description: Documentation for layout components including cards, accordions, and tabs in the Javaabu Forms package
category: components
order: 8
---

# Layout Components

This section covers all layout components including cards, accordions, tabs, and tables.

---

## Card

**File Path:** `src/Views/Components/Card.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$title` (string): Card title (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `header`: Card header slot
- `title`: Card title slot
- `subtitle`: Card subtitle slot
- `footer`: Card footer slot

**Example:**
```blade
<x-card title="Profile Information">
    <x-slot:header>
        <span class="badge">New</span>
    </x-slot:header>

    <!-- Card content -->

    <x-slot:footer>
        <x-button>Save Changes</x-button>
    </x-slot:footer>
</x-card>
```

---

## Accordion

**File Path:** `src/Views/Components/Accordion.php`

**Required Parameters:**
- `$id` (string): The accordion ID

**Constructor Parameters:**
- `$id` (string): The accordion ID
- `$items` (array|Collection): Array of accordion items (default: [])
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual accordion item (named with item index or name)

**Available Methods:**
- `generateSlotByName($name)`: Generates slot name from input name
- `generateCollapseIdByName($name)`: Generates collapse ID from name

**Example:**
```blade
<x-accordion id="accordion" :items="$items">
    <x-slot:item name="details">
        Details content
    </x-slot:item>

    <x-slot:item name="settings">
        Settings content
    </x-slot:item>
</x-accordion>
```

---

## Tabs

**File Path:** `src/Views/Components/Tabs.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$tabs` (array|Collection): Array of tabs (default: [])
- `$active` (string): Active tab name (default: first tab)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `nav-item`: Individual tab navigation item
- `pane`: Individual tab content pane

**Available Methods:**
- `isActive($name)`: Check if tab is active
- `generateSlotByName($name)`: Generate slot name from tab name
- `generateTitleByName($name)`: Generate title from tab name

**Example:**
```blade
<x-tabs :tabs="$tabs" active="profile">
    <x-slot:nav-item name="profile">
        <x-nav-item title="Profile" :active="$tabs->isActive('profile')" />
    </x-slot:nav-item>

    <x-slot:pane name="profile">
        <x-pane :active="$tabs->isActive('profile')">
            Profile content
        </x-pane>
    </x-slot:pane>
</x-tabs>
```

---

## Table

**File Path:** `src/Views/Components/Table.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$framework` (string): The UI framework (default: '')
- `$striped` (bool): Whether table is striped (default: false)
- `$noBulk` (bool): Disable bulk actions (default: false)
- `$model` (string): The model name (default: '')
- `$tableClass` (string): Custom table CSS class (default: '')
- `$filterId` (string): Filter component ID (default: null)
- `$noPagination` (bool): Disable pagination (default: false)
- `$noCheckbox` (bool): Disable checkboxes (default: false)

**Slots:**
- `row`: Table rows
- `cell`: Table cells
- `heading`: Table headings
- `empty-row`: Empty row display

**Available Methods:** None

**Example:**
```blade
<x-table :model="$users" striped>
    <x-slot:heading>
        <x-heading name="id" sortable label="ID" />
        <x-heading name="name" sortable label="Name" />
        <x-heading name="email" sortable label="Email" />
    </x-slot:heading>

    <x-slot:row>
        @foreach($users as $user)
            <x-row :model="$user">
                <x-cell :model="$user" name="id" />
                <x-cell :model="$user" name="name" />
                <x-cell :model="$user" name="email" />
            </x-row>
        @endforeach
    </x-slot:row>
</x-table>
```

---

## Accordion Components

This section covers individual accordion components.

---

## AccordionItem

**File Path:** `src/Views/Components/Accordion/Item.php`

**Required Parameters:**
- `$name` (string): Item name
- `$parent` (string): Parent accordion ID

**Constructor Parameters:**
- `$name` (string): Item name
- `$parent` (string): Parent accordion ID
- `$title` (string): Item title (default: '')
- `$content` (string): Item content (default: '')
- `$show` (bool): Whether item is open (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `header`: Item header
- `content`: Item content

**Example:**
```blade
<x-accordion-item name="details" parent="accordion" title="Details">
    <x-slot:content>
        Details content here
    </x-slot:content>
</x-accordion-item>
```

---

## AccordionHeader

**File Path:** `src/Views/Components/Accordion/Header.php`

**Required Parameters:**
- `$target` (string): Target collapse ID
- `$title` (string): Header title (default: '')
- `$show` (bool): Whether item is open (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Header body content

**Example:**
```blade
<x-accordion-header target="collapse-1" title="Section 1">
    <x-slot:body>
        Click to expand
    </x-slot:body>
</x-accordion-header>
```

---

## AccordionCollapse

**File Path:** `src/Views/Components/Accordion/Collapse.php`

**Required Parameters:**
- `$parent` (string): Parent accordion ID

**Constructor Parameters:**
- `$parent` (string): Parent accordion ID
- `$content` (string): Collapse content (default: '')
- `$show` (bool): Whether collapse is open (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Collapse body content

**Example:**
```blade
<x-accordion-collapse parent="accordion">
    <x-slot:body>
        <p>Collapse content here</p>
    </x-slot:body>
</x-accordion-collapse>
```

---

## Card Components

This section covers individual card components.

---

## CardHeader

**File Path:** `src/Views/Components/Card/Header.php`

**Slots:**
- `body`: Header body content

**Example:**
```blade
<x-card-header>
    <x-slot:body>
        Card header content
    </x-slot:body>
</x-card-header>
```

---

## CardTitle

**File Path:** `src/Views/Components/Card/Title.php`

**Slots:**
- `body`: Title body content

**Example:**
```blade
<x-card-title>
    <x-slot:body>
        Card Title
    </x-slot:body>
</x-card-title>
```

---

## CardSubtitle

**File Path:** `src/Views/Components/Card/Subtitle.php`

**Slots:**
- `body`: Subtitle body content

**Example:**
```blade
<x-card-subtitle>
    <x-slot:body>
        Card subtitle text
    </x-slot:body>
</x-card-subtitle>
```

---

## CardFooter

**File Path:** `src/Views/Components/Card/Footer.php`

**Slots:**
- `body`: Footer body content

**Example:**
```blade
<x-card-footer>
    <x-slot:body>
        <x-button>Footer Action</x-button>
    </x-slot:body>
</x-card-footer>
```

---

## Tabs Components

This section covers individual tab components.

---

## TabsNavItem

**File Path:** `src/Views/Components/Tabs/NavItem.php`

**Required Parameters:**
- `$title` (string): Tab title

**Constructor Parameters:**
- `$title` (string): Tab title
- `$name` (string): Tab name (default: '')
- `$target` (string): Target tab pane (default: '')
- `$url` (string): Tab URL (default: '#')
- `$active` (bool): Whether tab is active (default: false)
- `$disabled` (bool): Whether tab is disabled (default: false)
- `$isTab` (bool): Whether it's a tab (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Tab body content

**Example:**
```blade
<x-tabs-nav-item title="Profile" :active="$tabs->isActive('profile')" />
```

---

## TabsPane

**File Path:** `src/Views/Components/Tabs/Pane.php`

**Required Parameters:**
- `$active` (bool): Whether pane is active

**Constructor Parameters:**
- `$active` (bool): Whether pane is active
- `$name` (string): Pane name (default: '')
- `$target` (string): Target nav item (default: '')
- `$url` (string): Pane URL (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Pane body content

**Example:**
```blade
<x-tabs-pane :active="$tabs->isActive('profile')">
    <x-slot:body>
        Profile content
    </x-slot:body>
</x-tabs-pane>
```

---

## Table Components

This section covers individual table components.

---

## TableHeading

**File Path:** `src/Views/Components/Table/Heading.php`

**Required Parameters:**
- `$label` (string): Heading label

**Constructor Parameters:**
- `$label` (string): Heading label
- `$colspan` (int): Column span (default: 1)
- `$sortable` (string): Sortable field name (default: '')
- `$name` (string): Field name (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Heading body content

**Available Methods:**
- `addSortClass($classes)`: Adds sorting class

**Example:**
```blade
<x-table-heading name="name" sortable label="Name" />
```

---

## TableRow

**File Path:** `src/Views/Components/Table/Row.php`

**Required Parameters:**
- `$model` (mixed): Model instance

**Constructor Parameters:**
- `$name` (string): Table name (default: '')
- `$rowId` (string): Row ID (default: '')
- `$model` (mixed): Model instance
- `$modelId` (string): Model ID (default: '')
- `$noCheckbox` (bool): Whether to show checkbox (default: false)
- `$disableCheckbox` (bool): Whether to disable checkbox (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Row body content
- `checkbox`: Row checkbox

**Available Methods:**
- `generateRowId()`: Generate row ID
- `getRowId()`: Get row ID
- `getCheckboxId()`: Get checkbox ID

**Example:**
```blade
<x-table-row :model="$user">
    <x-slot:checkbox>
        <x-checkbox :model="$user" name="ids[]" :value="$user->id" />
    </x-slot:checkbox>

    <x-slot:body>
        <x-cell :model="$user" name="name" />
        <x-cell :model="$user" name="email" />
    </x-slot:body>
</x-table-row>
```

---

## TableCell

**File Path:** `src/Views/Components/Table/Cell.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): Field name (default: '')
- `$label` (string): Cell label (default: '')
- `$showLabel` (bool): Whether to show label (default: true)
- `$value` (mixed): Value to display (default: from model)
- `$model` (mixed): Model to bind to
- `$multiline` (bool): Whether multiline (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Cell body content

**Available Methods:**
- `formatValue()`: Formats the value

**Example:**
```blade
<x-table-cell name="email" label="Email">
    <x-slot:body>
        {{ $user->email }}
    </x-slot:body>
</x-table-cell>
```

---

## TableEmptyRow

**File Path:** `src/Views/Components/Table/EmptyRow.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$columns` (int): Number of columns (default: 1)
- `$noCheckbox` (bool): Whether to show checkbox (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-table-empty-row :columns="3" />
```
