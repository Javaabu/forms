---
title: Utility Components
description: Documentation for utility components including infolists, search forms, filters, and more in the Javaabu Forms package
category: components
order: 11
---

# Utility Components

This section covers all utility components including infolists, search forms, filters, and bulk actions.

---

## Infolist

**File Path:** `src/Views/Components/Infolist.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$title` (string): Card title (default: '')
- `$model` (mixed): The model to display
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual info item
- `title`: Card title slot
- `subtitle`: Card subtitle slot

**Example:**
```blade
<x-infolist :model="$user" title="User Profile">
    <x-slot:item name="email">
        <x-label>📧 Email</x-label>
        <x-text-entry :model="$user" name="email" :show-label="false" />
    </x-slot:item>
</x-infolist>
```

---

## SearchForm

**File Path:** `src/Views/Components/SearchForm.php`

**Required Parameters:**
- `$action` (string): Form action URL

**Constructor Parameters:**
- `$name` (string): Search parameter name (default: 'search')
- `$action` (string): Form action URL (default: '')
- `$route` (string): Route name for action (default: '')
- `$params` (array): Route parameters (default: [])
- `$placeholder` (string): Search placeholder (default: '')
- `$icon` (string): Search icon (default: from config)
- `$method` (string): HTTP method (default: 'GET')
- `$model` (mixed): The model to bind to (default: request()->query())
- `$files` (bool): Whether to handle files (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-search-form action="/users" placeholder="Search users..." />
```

---

## Filter

**File Path:** `src/Views/Components/Filter.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual filter item

**Example:**
```blade
<x-filter>
    <x-slot:item name="search">
        <x-input name="search" label="Search" />
    </x-slot:item>

    <x-slot:item name="status">
        <x-select name="status" label="Status" :options="$statuses" />
    </x-slot:item>
</x-filter>
```

---

## FilterSubmit

**File Path:** `src/Views/Components/FilterSubmit.php`

**Required Parameters:**
- `$cancelUrl` (string): URL to cancel/filter

**Constructor Parameters:**
- `$cancelUrl` (string): URL to cancel/filter
- `$export` (bool|array): Export actions (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-filter-submit cancel-url="/users" :export="['csv', 'pdf']" />
```

---

## PerPage

**File Path:** `src/Views/Components/PerPage.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$amounts` (array): Page amounts array (default: [10, 20, 50, 100, 500])
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-per-page :amounts="[10, 25, 50, 100]" />
```

---

## BulkActions

**File Path:** `src/Views/Components/BulkActions.php`

**Required Parameters:**
- `$model` (string): The model class name

**Constructor Parameters:**
- `$model` (string): The model class name
- `$actions` (array): Array of bulk actions
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-bulk-actions model="App\Models\User" :actions="$actions">
    <x-select name="action" label="Bulk Action">
        <option value="delete">Delete</option>
        <option value="archive">Archive</option>
    </x-select>
</x-bulk-actions>
```

---

## ConditionalLink

**File Path:** `src/Views/Components/ConditionalLink.php`

**Required Parameters:**
- `$url` (string): The URL to link to

**Constructor Parameters:**
- `$url` (string): The URL to link to
- `$name` (string): Field name to check (default: '')
- `$showLink` (bool|null): Whether to show link (default: null)
- `$can` (string): Permission to check (default: '')
- `$arg` (array): Arguments for permission check (default: [])
- `$guard` (string|null): Auth guard (default: null)
- `$value` (mixed): Value to check (default: from model)
- `$model` (mixed): Model to bind to
- `$multiline` (bool): Whether multiline (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-conditional-link url="/settings" name="is_admin" can="edit_settings">
    Edit Settings
</x-conditional-link>
```

---

## ConditionalWrapper

**File Path:** `src/Views/Components/ConditionalWrapper.php`

**Required Parameters:**
- `$enableElem` (string): Element to check
- `$enableValue` (mixed): Value to enable on

**Constructor Parameters:**
- `$enableElem` (string): Element to check
- `$enableValue` (mixed): Value to enable on
- `$hideFields` (bool): Whether to hide fields (default: false)
- `$disable` (bool): Whether to disable fields (default: false)
- `$enableCheckbox` (bool): Whether to use checkbox (default: false)
- `$jsonEncode` (bool|null): Whether to JSON encode (default: auto-detect)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `checkbox`: Conditional checkbox
- `content`: Conditional content

**Example:**
```blade
<x-conditional-wrapper enable-elem="account_type" enable-value="premium">
    <x-slot:checkbox>
        <x-checkbox name="premium" label="Premium Account" />
    </x-slot:checkbox>

    <x-slot:content>
        Premium features go here...
    </x-slot:content>
</x-conditional-wrapper>
```

---

## Modal

**File Path:** `src/Views/Components/Modal.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$id` (string): Modal ID (default: '')
- `$title` (string): Modal title (default: '')
- `$modalSizeClass` (string): Modal size class (default: null)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `header`: Modal header slot
- `body`: Modal body slot
- `footer`: Modal footer slot

**Example:**
```blade
<x-modal id="confirm-modal" title="Confirm Action">
    <x-slot:body>
        Are you sure you want to proceed?
    </x-slot:body>

    <x-slot:footer>
        <x-button color="danger">Confirm</x-button>
        <x-button color="secondary" @click="$dispatch('close')">Cancel</x-button>
    </x-slot:footer>
</x-modal>
```

---

## Utility Components Usage Examples

### Infolist with User Profile
```blade
<x-infolist :model="$user" title="User Profile">
    <x-slot:item name="name">
        <x-label>Name</x-label>
        <x-text-entry :model="$user" name="name" :show-label="false" />
    </x-slot:item>

    <x-slot:item name="email">
        <x-label>Email</x-label>
        <x-text-entry :model="$user" name="email" :show-label="false" />
    </x-slot:item>

    <x-slot:item name="avatar">
        <x-label>Avatar</x-label>
        <x-image :model="$user" name="avatar" width="100" height="100" circle />
    </x-slot:item>
</x-infolist>
```

### Infolist with Device Info
```blade
<x-infolist :model="$device" title="Device Details">
    <x-slot:item name="device_id">
        <x-label>Device ID</x-label>
        <x-text-entry :model="$device" name="device_id" :show-label="false" />
    </x-slot:item>

    <x-slot:item name="ip_address">
        <x-label>IP Address</x-label>
        <x-text-entry :model="$device" name="ip_address" :show-label="false" />
    </x-slot:item>

    <x-slot:item name="location">
        <x-label>Location</x-label>
        <x-text-entry :model="$device" name="location" :show-label="false" />
    </x-slot:item>
</x-infolist>
```

### Search Form
```blade
<x-search-form
    action="/users"
    placeholder="Search users by name or email..."
    icon="search"
    method="GET"
/>
```

### Search Form with Route
```blade
<x-search-form
    :route="route('users.index')"
    :params="['category' => 'premium']"
    placeholder="Search premium users..."
/>
```

### Search Form with Custom Model
```blade
<x-search-form
    action="/search"
    :model="$searchQuery"
    placeholder="Search products..."
/>
```

### Filter with Multiple Fields
```blade
<x-filter>
    <x-slot:item name="search">
        <x-input name="search" label="Search" placeholder="Search..." />
    </x-slot:item>

    <x-slot:item name="category">
        <x-select name="category" label="Category" :options="$categories" />
    </x-slot:item>

    <x-slot:item name="status">
        <x-select name="status" label="Status" :options="$statuses" />
    </x-slot:item>

    <x-slot:item name="date_range">
        <x-date name="start_date" label="From" />
        <x-date name="end_date" label="To" />
    </x-slot:item>

    <x-slot:item name="sort">
        <x-select name="sort" label="Sort By" :options="$sortOptions" />
    </x-slot:item>
</x-filter>
```

### FilterSubmit with Export Options
```blade
<x-filter-submit
    cancel-url="/products"
    :export="['csv', 'pdf', 'excel']"
/>
```

### PerPage with Custom Options
```blade
<x-per-page :amounts="[10, 25, 50, 100, 250, 500, 1000]" />
```

### PerPage with Compact Options
```blade
<x-per-page :amounts="[5, 10, 20]" />
```

### BulkActions with Multiple Actions
```blade
<x-bulk-actions model="App\Models\Post" :actions="$bulkActions">
    <x-select name="action" label="Bulk Action" required>
        <option value="">-- Select Action --</option>
        <option value="publish">Publish Selected</option>
        <option value="archive">Archive Selected</option>
        <option value="delete">Delete Selected</option>
    </x-select>
</x-bulk-actions>
```

### BulkActions with Custom Class
```blade
<x-bulk-actions
    model="App\Models\Product"
    :actions="$bulkActions"
    :class="custom-bulk-actions-class"
/>
```

### ConditionalLink
```blade
<x-conditional-link url="/settings" name="is_admin" can="edit_settings">
    Edit Settings
</x-conditional-link>

<x-conditional-link
    url="/delete"
    name="is_active"
    can="delete_users"
    :arg="['user' => $user->id]"
>
    Delete User
</x-conditional-link>
```

### ConditionalLink with Multiline
```blade
<x-conditional-link
    url="/settings"
    name="is_admin"
    can="edit_settings"
    multiline
>
    Edit Settings
    <br>
    <small>Requires admin privileges</small>
</x-conditional-link>
```

### ConditionalWrapper
```blade
<x-conditional-wrapper enable-elem="account_type" enable-value="premium">
    <x-slot:checkbox>
        <x-checkbox name="premium" label="Premium Account" />
    </x-slot:checkbox>

    <x-slot:content>
        <div class="premium-features">
            <h4>Premium Features</h4>
            <ul>
                <li>Unlimited storage</li>
                <li>Priority support</li>
                <li>Advanced analytics</li>
            </ul>
        </div>
    </x-slot:content>
</x-conditional-wrapper>
```

### ConditionalWrapper with Hide Fields
```blade
<x-conditional-wrapper
    enable-elem="status"
    enable-value="draft"
    :hide-fields="true"
>
    <x-input name="title" label="Title" />
    <x-textarea name="content" label="Content" rows="10" />
</x-conditional-wrapper>
```

### ConditionalWrapper with Checkbox
```blade
<x-conditional-wrapper enable-elem="is_feature" enable-value="true">
    <x-slot:checkbox>
        <x-checkbox name="is_feature" label="Mark as Featured" />
    </x-slot:checkbox>

    <x-slot:content>
        Featured content goes here...
    </x-slot:content>
</x-conditional-wrapper>
```

### Modal for Confirmation
```blade
<x-modal id="confirm-delete" title="Delete Item">
    <x-slot:body>
        Are you sure you want to delete this item? This action cannot be undone.
    </x-slot:body>

    <x-slot:footer>
        <x-button color="danger" @click="deleteItem">Delete</x-button>
        <x-button color="secondary" @click="$dispatch('close')">Cancel</x-button>
    </x-slot:footer>
</x-modal>

<button @click="$dispatch('open')">Delete Item</button>
```

### Modal with Dynamic Content
```blade
<x-modal id="user-modal" :title="'User: ' + user.name">
    <x-slot:body>
        <div class="user-details">
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p><strong>Role:</strong> {{ user.role }}</p>
            <p><strong>Status:</strong> {{ user.status }}</p>
        </div>
    </x-slot:body>

    <x-slot:footer>
        <x-button color="primary" @click="editUser">Edit User</x-button>
        <x-button color="secondary" @click="$dispatch('close')">Cancel</x-button>
    </x-slot:footer>
</x-modal>
```

### Modal with Large Size
```blade
<x-modal
    id="large-modal"
    title="Large Modal"
    modal-size-class="modal-lg"
>
    <x-slot:body>
        This is a large modal with more content...
    </x-slot:body>
</x-modal>
```

### Modal with Custom Class
```blade
<x-modal id="custom-modal" title="Custom Modal" :class="custom-modal-class">
    <x-slot:body>
        Custom modal content...
    </x-slot:body>
</x-modal>
```
