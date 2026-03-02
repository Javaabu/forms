---
title: Feedback Components
description: Documentation for feedback components including alerts, status indicators, and no items displays in the Javaabu Forms package
category: components
order: 9
---

# Feedback Components

This section covers all feedback components including alerts, status indicators, and no items displays.

---

## Alert

**File Path:** `src/Views/Components/Alert.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$type` (string): Alert type (default: 'primary')
- `$dismissible` (bool): Whether alert can be dismissed (default: false)
- `$icon` (string): Icon to display (default: '')
- `$heading` (string): Alert heading (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Alert body content

**Example:**
```blade
<x-alert type="success" dismissible>
    <x-slot:body>
        Your changes have been saved successfully!
    </x-slot:body>
</x-alert>
```

---

## Status

**File Path:** `src/Views/Components/Status.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$label` (string): Status label (default: '')
- `$color` (string): Status color (default: 'primary')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-status label="Published" color="success" />
<x-status label="Draft" color="warning" />
```

---

## NoItems

**File Path:** `src/Views/Components/NoItems.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$createAction` (string): Create action URL (default: '#')
- `$model` (mixed): The model (default: null)
- `$icon` (string): Icon to display (default: from config)
- `$modelType` (string): Model type name (default: null)
- `$showCreate` (bool): Whether to show create button (default: from auth)
- `$title` (string): Title text (default: from translation)
- `$message` (string): Message text (default: from translation)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-no-items :model="$posts" :create-action="route('posts.create')" model-type="Posts" />
```

---

## Feedback Components Usage Examples

### Success Alert
```blade
<x-alert type="success" dismissible>
    <x-slot:body>
        Your changes have been saved successfully!
    </x-slot:body>
</x-alert>
```

### Warning Alert
```blade
<x-alert type="warning" dismissible>
    <x-slot:body>
        Your session is about to expire. Please extend your session.
    </x-slot:body>
</x-alert>
```

### Error Alert
```blade
<x-alert type="danger" dismissible>
    <x-slot:body>
        An error occurred while processing your request.
    </x-slot:body>
</x-alert>
```

### Info Alert
```blade
<x-alert type="info" dismissible>
    <x-slot:body>
        New features are available in this version.
    </x-slot:body>
</x-alert>
```

### Alert with Icon
```blade
<x-alert type="success" icon="success" dismissible>
    <x-slot:body>
        Your changes have been saved successfully!
    </x-slot:body>
</x-alert>
```

### Alert with Custom Heading
```blade
<x-alert type="info" heading="Important Notice" dismissible>
    <x-slot:body>
        This is an important notification that you should read.
    </x-slot:body>
</x-alert>
```

### Alert with Custom Content
```blade
<x-alert type="success" dismissible>
    <x-slot:body>
        <div class="alert-content">
            <h4>Operation Successful</h4>
            <p>Your data has been processed correctly.</p>
            <a href="/details" class="btn btn-primary">View Details</a>
        </div>
    </x-slot:body>
</x-alert>
```

### Status Indicator - Success
```blade
<x-status label="Published" color="success" />
```

### Status Indicator - Warning
```blade
<x-status label="Pending Review" color="warning" />
```

### Status Indicator - Danger
```blade
<x-status label="Expired" color="danger" />
```

### Status Indicator - Info
```blade
<x-status label="In Progress" color="info" />
```

### Status Indicator - Primary
```blade
<x-status label="Draft" color="primary" />
```

### Status Indicator - Custom Color
```blade
<x-status label="Active" color="custom-color" />
```

### No Items - With Create Button
```blade
<x-no-items
    :model="$posts"
    :create-action="route('posts.create')"
    model-type="Posts"
/>
```

### No Items - Without Create Button
```blade
<x-no-items
    :model="$posts"
    :create-action="#"
    model-type="Posts"
    :show-create="false"
/>
```

### No Items - Custom Message
```blade
<x-no-items
    :model="$products"
    :create-action="route('products.create')"
    model-type="Products"
    title="No Products Found"
    message="We couldn't find any products matching your search."
/>
```

### No Items - Custom Icon
```blade
<x-no-items
    :model="$users"
    :create-action="route('users.create')"
    model-type="Users"
    :icon="custom-icon"
/>
```

### Alert with Different States
```blade
<div class="alert-container">
    <x-alert type="success" dismissible>
        <x-slot:body>Operation completed successfully.</x-slot:body>
    </x-alert>

    <x-alert type="warning" dismissible>
        <x-slot:body>Please review your changes before submitting.</x-slot:body>
    </x-alert>

    <x-alert type="danger" dismissible>
        <x-slot:body>An error occurred. Please try again.</x-slot:body>
    </x-alert>

    <x-alert type="info" dismissible>
        <x-slot:body>New feature available: Dark mode support.</x-slot:body>
    </x-alert>
</div>
```

### Status Indicators in Table
```blade
<table class="table">
    <tr>
        <th>Name</th>
        <th>Status</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>
                <x-status
                    :label="$user->status"
                    :color="$user->status_color"
                />
            </td>
        </tr>
    @endforeach
</table>
```

### Status Indicators in Card
```blade
<x-card title="Project Status">
    <div class="project-info">
        <p>Current Status: <x-status label="In Progress" color="info" /></p>
        <p>Due Date: 2025-03-31</p>
    </div>
</x-card>
```

### No Items with Custom Styling
```blade
<div class="no-items-wrapper">
    <x-no-items
        :model="$items"
        :create-action="route('items.create')"
        model-type="Items"
    >
        <template #content>
            <p class="custom-message">Custom message for empty state</p>
        </template>
    </x-no-items>
</div>
```

### Nested Alerts
```blade
<x-alert type="warning" dismissible>
    <x-slot:body>
        <strong>System Maintenance:</strong> Scheduled maintenance is in progress.
        <x-alert type="info" dismissible>
            <x-slot:body>
                Maintenance is expected to complete by 10:00 PM EST.
            </x-slot:body>
        </x-alert>
    </x-slot:body>
</x-alert>
```

### Alert with Inline Action
```blade
<x-alert type="info" dismissible>
    <x-slot:body>
        <p>New features are available!</p>
        <a href="/changelog" class="btn btn-primary">View Changelog</a>
    </x-slot:body>
</x-alert>
```

### Status with Custom Classes
```blade
<x-status
    label="Active"
    color="success"
    :class="custom-status-class"
/>
```
