---
title: Select Components
description: Documentation for select dropdown components in the Javaabu Forms package
category: components
order: 6
---

# Select Components

This section covers all select dropdown components including standard selects, Select2, and AJAX options.

---

## Select

**File Path:** `src/Views/Components/Select.php`

**Required Parameters:**
- `$name` (string): The select field name

**Constructor Parameters:**
- `$name` (string): The select field name
- `$label` (string): The field label (default: '')
- `$placeholder` (string): Placeholder text (default: '')
- `$options` (array|Collection): Options array or query builder
- `$model` (mixed): The model to bind to
- `$default` (mixed): Default value (default: from model)
- `$multiple` (bool): Allow multiple selections (default: false)
- `$relation` (bool): Is this a relation (default: false)
- `$showErrors` (bool): Whether to show validation errors (default: true)
- `$showLabel` (bool): Whether to show the label (default: true)
- `$showPlaceholder` (bool): Whether to show placeholder (default: false)
- `$required` (bool): Whether field is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$isSelect2` (bool): Use Select2 library (default: false)
- `$isAjax` (bool): Use AJAX for options (default: false)
- `$disabled` (bool): Whether to disable (default: false)
- `$excludeSyncField` (bool): Exclude sync field (default: false)
- `$syncFieldName` (string): Sync field name (default: 'sync_{{name}}')
- `$nameField` (string): Name field for options (default: 'name')
- `$idField` (string): ID field for options (default: 'id')
- `$tags` (bool): Allow tag input (default: false)
- `$inlineLabelClass` (string): Custom CSS class for inline labels (default: '')
- `$inlineInputClass` (string): Custom CSS class for inline input (default: '')
- `$formGroupClass` (string): Custom CSS class for form group (default: '')
- `$showJsErrors` (bool): Whether to show JavaScript errors (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Methods:**
- `getOptionsFromQueryBuilder($query)`: Gets options from a query builder
- `isSelected($key)`: Check if a key is selected
- `nothingSelected()`: Check if nothing is selected
- `shouldShowSyncField()`: Check if sync field should be shown

**Slots:** None

**Example:**
```blade
<x-select name="country" label="Country" :options="$countries" />
```

---

## Select2

**File Path:** `src/Views/Components/Select2.php`

**Inherits from:** Select

**Required Parameters:**
- `$name` (string): The select field name

**Constructor Parameters:**
- Same as Select component
- `$allowClear` (bool): Allow clearing selection (default: true)
- `$isFirst` (bool): Is first select in cascade (default: false)
- `$hideSearch` (bool): Hide search bar (default: false)
- `$child` (string): Child select name (default: '')
- `$ajaxChild` (string): AJAX child select name (default: '')
- `$ajaxUrl` (string): AJAX URL (default: '')
- `$selectedUrl` (string): Selected value URL (default: '')
- `$filterField` (string): Filter field (default: '')
- `$fallback` (string): Fallback value (default: '')
- `$parentModal` (string): Parent modal ID (default: '')
- `$iconPrefix` (string): Icon prefix (default: '')
- Same as Select component for all other parameters

**Available Methods:**
- `getNothingSelectedText()`: Returns the "nothing selected" text

**Slots:** None

**Example:**
```blade
<x-select2 name="category" label="Category" :options="$categories" allow-clear />
```

---

## Select Usage Examples

### Basic Select Dropdown
```blade
<x-select name="country" label="Country" :options="$countries" />
```

### Select with Placeholder
```blade
<x-select name="country" label="Select Country" :options="$countries" placeholder="Choose a country" />
```

### Select with Model Binding
```blade
<x-select name="country_id" :model="$user" :options="$countries" />
```

### Select with Multiple Options
```blade
<x-select name="colors" label="Favorite Colors" :options="$colors" :multiple="true" />
```

### Select with Required Field
```blade
<x-select name="category" label="Category" :options="$categories" required />
```

### Select with Inline Rendering
```blade
<x-select name="status" label="Status" :options="$statuses" :inline="true" />
```

### Select with Floating Label
```blade
<x-select name="status" label="Status" :options="$statuses" :floating="true" />
```

### Select with Custom CSS Classes
```blade
<x-select
    name="country"
    label="Country"
    :options="$countries"
    :form-group-class="'custom-form-group'"
    :inline-label-class="'custom-label'"
    :inline-input-class="'custom-input'"
/>
```

### Select from Query Builder
```blade
<x-select name="user" label="User" :options="$users->orderBy('name')" />
```

### Select with Custom Field Names
```blade
<x-select
    name="category"
    label="Category"
    :options="$categories"
    :name-field="'name'"
    :id-field="'slug'"
/>
```

### Select with Sync Field
```blade
<x-select name="role_id" label="Role" :options="$roles" :sync-field-name="'sync_role_id'" />
```

### Select with Tags Input
```blade
<x-select name="tags" label="Tags" :options="$tags" :tags="true" :multiple="true" />
```

### Select with JavaScript Errors
```blade
<x-select name="category" label="Category" :options="$categories" :show-js-errors="true" />
```

### Select from Collection
```blade
<x-select name="priority" label="Priority" :options="$priorities" />
```

---

## Select2 Usage Examples

### Basic Select2
```blade
<x-select2 name="category" label="Category" :options="$categories" />
```

### Select2 with Allow Clear
```blade
<x-select2 name="category" label="Category" :options="$categories" allow-clear />
```

### Select2 with Hide Search
```blade
<x-select2 name="category" label="Category" :options="$categories" :hide-search="true" />
```

### Select2 Cascade
```blade
<x-select2 name="category" label="Category" :options="$categories" allow-clear />

<x-select2
    name="subcategory"
    label="Subcategory"
    :options="$subcategories"
    child="category"
/>
```

### Select2 with AJAX
```blade
<x-select2
    name="country"
    label="Country"
    :ajax-url="route('countries.ajax')"
/>
```

### Select2 with Modal
```blade
<x-select2
    name="region"
    label="Region"
    :options="$regions"
    :parent-modal="'region-modal'"
/>
```

### Select2 with Filter Field
```blade
<x-select2
    name="city"
    label="City"
    :ajax-url="route('cities.ajax')"
    :filter-field="'country_id'"
    :fallback="'Select country first'"
/>
```

### Select2 with Nothing Selected Text
```blade
<x-select2
    name="country"
    label="Country"
    :options="$countries"
    :nothing-selected-text="'Please select a country'"
/>
```

### Select2 with Disabled State
```blade
<x-select2 name="category" label="Category" :options="$categories" :disabled="true" />
```

### Select2 with Required Field
```blade
<x-select2 name="category" label="Category" :options="$categories" required />
```

### Select2 with Custom Icons
```blade
<x-select2
    name="category"
    label="Category"
    :options="$categories"
    :icon-prefix="custom-prefix"
/>
```

### Select2 with Custom Class
```blade
<x-select2
    name="category"
    label="Category"
    :options="$categories"
    :form-group-class="'custom-select-group'"
/>
```
