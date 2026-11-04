---
title: Conditional link
sidebar_position: 13
---

# Conditional link

`<x-forms::conditional-link>` renders its content as a link only when a condition holds, for example when the user may view the page it links to. Otherwise it renders the content as plain text.

## Showing a link when a condition holds

```blade
<x-forms::conditional-link :url="route('admin.users.index', $organization)" :show-link="$can_view_users">
    {{ $organization->users_count }}
</x-forms::conditional-link>
```

## Checking a permission

Instead of `show-link`, pass an ability to `can` and its argument to `arg`. The link shows when the signed-in user is authorized:

```blade
<x-forms::conditional-link :url="route('admin.users.index')" can="viewAny" :arg="App\Models\User::class">
    {{ __('Users') }}
</x-forms::conditional-link>

{{-- with another guard --}}
<x-forms::conditional-link :url="route('admin.users.index')" can="viewAny" :arg="App\Models\User::class" guard="admin">
    {{ __('Users') }}
</x-forms::conditional-link>
```

`can` is only checked when `show-link` isn't given. For guests the link is hidden. To decide yourself, pass `show-link`:

```blade
<x-forms::conditional-link :url="$url" :show-link="auth()->user()?->can('view', $island) ?? false">
    {{ $island->name }}
</x-forms::conditional-link>
```

## Showing a value instead of a slot

Without a slot, the component shows `value`, or the bound model's attribute named `name`. Values are formatted like [text entries](./text-entry.md): enums show their label (or a status badge when they have a colour), `true`/`false` show "Yes"/"No", arrays are joined with commas, and empty values show "-".

```blade
<x-forms::conditional-link :url="route('admin.users.index')" can="viewAny" :arg="App\Models\User::class" :value="$users_count" />

@model($organization)
    <x-forms::conditional-link :url="route('admin.users.index', $organization)" can="viewAny" :arg="App\Models\User::class" name="users_count" />
@endmodel
```

When the value is a model with an `admin_link` accessor (Javaabu's admin models), its `admin_link_name` is shown. `multiline` keeps line breaks in text values.

## Other attributes

Attributes such as `target`, `class` or `title` go on the `<a>` tag, so they're only rendered when the link is:

```blade
<x-forms::conditional-link :url="$document_url" :show-link="$is_published" target="_blank" class="underline">
    {{ __('View') }}
</x-forms::conditional-link>
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `url` | `string` | required | Link URL. |
| `show-link` | `bool` | `null` | Renders the link when `true`. When not given, `can` decides. |
| `can` | `string` | `''` | Ability to check with the signed-in user's `can()`. |
| `arg` | `mixed` | `[]` | Argument for the ability. |
| `guard` | `string` | default guard | Guard to get the user from. |
| `value` | `mixed` | `null` | Value to show when there is no slot. |
| `name` | `string` | `''` | Bound model attribute to show when there is no slot and no `value`. |
| `model` | `mixed` | bound model | Model to read `name` from. |
| `multiline` | `bool` | `false` | Keeps line breaks in the value. |
| `framework` | `string` | config | `onu` or `bootstrap-6`, for status badges. |

Slot: the content.

## React

```jsx
import { ConditionalLink } from "@javaabu/forms"

<ConditionalLink url="/admin/users" showLink={canViewUsers}>
  {usersCount}
</ConditionalLink>
```

See [Parity](../parity.md).
