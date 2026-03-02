---
title: Base Components
description: Documentation for the base components in the Javaabu Forms package
category: components
order: 1
---

# Base Components

This section covers the foundational components provided by the Javaabu Forms package. These components serve as building blocks for more complex form elements and UI components.

---

## Component

**File Path:** `src/Views/Components/Component.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$framework` (string, optional): The UI framework to use (default: from config)

**Available Methods:**
- `id()`: Generates a unique ID for the component
- `label()`: Generates a label based on the component name
- `stringToId($text)`: Converts text to a valid ID
- `getFrameworkIcon($icon)`: Gets the framework icon prefix and format
- `frameworkConfig($config, $default)`: Gets framework-specific configuration

**Slots:** None

**Example:**
```blade
<x-component />
```

---

## FormGroup

**File Path:** `src/Views/Components/FormGroup.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): The form field name
- `$label` (string): The field label (default: '')
- `$required` (bool): Whether the field is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$wrap` (bool): Whether to wrap the field (default: true)
- `$showLabel` (bool): Whether to show the label (default: true)
- `$inlineLabelClass` (string): Custom CSS class for inline labels (default: '')
- `$inlineInputClass` (string): Custom CSS class for inline input (default: '')
- `$blankLabel` (bool): Whether to show blank label (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Methods:**
- `label()`: Returns the label (or empty string if blank)

**Slots:** None

**Example:**
```blade
<x-form-group name="email" label="Email Address" required />
```

---

## Form

**File Path:** `src/Views/Components/Form.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$method` (string): HTTP method (default: 'POST')
- `$model` (mixed): The model to bind to
- `$files` (bool): Whether to handle file uploads (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Properties:**
- `$method`: The HTTP method
- `$spoofMethod`: Whether to spoof the method for PUT/PATCH/DELETE
- `$files`: Whether files are enabled

**Available Methods:**
- `bindModel($model)`: Binds a model to the form

**Slots:** None

**Example:**
```blade
<x-form method="POST" :model="$user" :files="true">
    <!-- Form fields -->
</x-form>
```

---

## FormOpen

**File Path:** `src/Views/Components/FormOpen.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$method` (string): HTTP method (default: 'POST')
- `$model` (mixed): The model to bind to
- `$files` (bool): Whether to handle file uploads (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-form-open method="POST" :model="$user" :files="true">
    <!-- Form fields -->
</x-form-open>
```

---

## FormClose

**File Path:** `src/Views/Components/FormClose.php`

**Slots:** None

**Example:**
```blade
<x-form-open method="POST" :model="$user">
    <!-- Form fields -->
</x-form-open>
<x-form-close />
```

---

## Form Control Components

This section covers form control components including labels, help text, and error handling.

---

## Label

**File Path:** `src/Views/Components/Label.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$label` (string): The label text (default: '')
- `$required` (bool): Whether label is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$inlineLabelClass` (string): Custom CSS class (default: '')
- `$blankLabel` (bool): Whether to show blank label (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-label for="email" required>Email Address</x-label>
```

---

## LabelRequired

**File Path:** `src/Views/Components/LabelRequired.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$text` (string): Required text (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-label-required />
```

---

## InputHelp

**File Path:** `src/Views/Components/InputHelp.php`

**Slots:** None

**Example:**
```blade
<x-input-help>Additional information goes here.</x-input-help>
```

---

## Errors

**File Path:** `src/Views/Components/Errors.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): Field name (default: '')
- `$bag` (string): Error bag name (default: 'default')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-errors name="email" bag="default" />
```

---

## JsErrors

**File Path:** `src/Views/Components/JsErrors.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): Field name (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-js-errors name="email" />
```

---

## Wysiwyg

**File Path:** `src/Views/Components/Wysiwyg.php`

**Required Parameters:**
- `$name` (string): The WYSIWYG field name

**Constructor Parameters:**
- Same as Input component

**Slots:** None

**Example:**
```blade
<x-wysiwyg name="content" label="Content" />
```

---

## Hidden Component

This section covers the hidden field component.

---

## Hidden

**File Path:** `src/Views/Components/Hidden.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The hidden field name

**Constructor Parameters:**
- Same as Input component (except `$type` defaults to 'hidden')

**Slots:** None

**Example:**
```blade
<x-hidden name="user_id" value="{{ $user->id }}" />
```
