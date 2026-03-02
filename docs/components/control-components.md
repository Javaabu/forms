---
title: Control Components
description: Documentation for button and control components in the Javaabu Forms package
category: components
order: 7
---

# Control Components

This section covers all control components including buttons, submit buttons, and link buttons.

---

## Button

**File Path:** `src/Views/Components/Button.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$type` (string): Button type (default: '')
- `$color` (string): Button color (default: 'primary')
- `$animate` (bool): Whether to add animation (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-button type="submit" color="primary">Submit</x-button>
<x-button type="button" color="danger">Cancel</x-button>
```

---

## Submit

**File Path:** `src/Views/Components/Submit.php`

**Inherits from:** Button

**Required Parameters:** None

**Constructor Parameters:**
- `$color` (string): Button color (default: 'primary')
- `$framework` (string): The UI framework (default: '')

**Example:**
```blade
<x-submit>Save Changes</x-submit>
```

---

## LinkButton

**File Path:** `src/Views/Components/LinkButton.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$url` (string): Button URL (default: '')
- `$color` (string): Button color (default: 'primary')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-link-button url="/users" color="primary">View All Users</x-link-button>
```

---

## ButtonGroup

**File Path:** `src/Views/Components/ButtonGroup.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$inline` (bool): Whether to render inline (default: true)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-button-group inline>
    <x-button>Button 1</x-button>
    <x-button>Button 2</x-button>
</x-button-group>
```

---

## Control Components Usage Examples

### Primary Button
```blade
<x-button type="submit" color="primary">Save Changes</x-button>
```

### Secondary Button
```blade
<x-button type="button" color="secondary">Cancel</x-button>
```

### Success Button
```blade
<x-button type="button" color="success">Create New</x-button>
```

### Danger Button
```blade
<x-button type="button" color="danger">Delete</x-button>
```

### Warning Button
```blade
<x-button type="button" color="warning">Confirm</x-button>
```

### Info Button
```blade
<x-button type="button" color="info">Learn More</x-button>
```

### Dark Button
```blade
<x-button type="button" color="dark">Close</x-button>
```

### Outline Buttons
```blade
<x-button type="button" color="primary" outline>Primary</x-button>
<x-button type="button" color="secondary" outline>Secondary</x-button>
```

### Button with Animation
```blade
<x-button type="button" color="primary" :animate="true">Click Me</x-button>
```

### Submit Button
```blade
<x-submit>Save Changes</x-submit>
```

### Link Button
```blade
<x-link-button url="/users" color="primary">View All Users</x-link-button>
```

### Link Button with External URL
```blade
<x-link-button url="https://example.com" color="secondary">Visit External Site</x-link-button>
```

### Inline Button Group
```blade
<x-button-group inline>
    <x-button>Left</x-button>
    <x-button>Center</x-button>
    <x-button>Right</x-button>
</x-button-group>
```

### Block Button
```blade
<x-button type="submit" color="primary" block>Submit Form</x-button>
```

### Button with Custom CSS
```blade
<x-button
    type="button"
    color="primary"
    :style="{ padding: '10px 20px', borderRadius: '5px' }"
>
    Custom Button
</x-button>
```

### Button with Attributes
```blade
<x-button
    type="button"
    color="primary"
    data-id="{{ $user->id }}"
    :disabled="!$user->canDelete"
>
    Delete User
</x-button>
```

### Grouped Buttons
```blade
<x-button-group inline>
    <x-button type="button" color="secondary">Edit</x-button>
    <x-button type="button" color="danger">Delete</x-button>
</x-button-group>
```

### Icon Button
```blade
<x-button type="button" color="primary">
    <x-icon name="save" />
    Save
</x-button>
```

### Loading Button
```blade
<x-button type="button" color="primary" :loading="isLoading">
    {{ isLoading ? 'Saving...' : 'Save' }}
</x-button>
```

### Disabled Button
```blade
<x-button type="button" color="primary" :disabled="true">Disabled</x-button>
```

### Button with Conditional Logic
```blade
@if($user->isAdmin)
    <x-button type="button" color="danger" @click="deleteUser({{ $user->id }})">
        Delete User
    </x-button>
@endif
```
