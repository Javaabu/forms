---
title: Conditional Link
sidebar_position: 11
---

You can use the `conditional-link` component to render `<a>` tags conditionally. This can be useful if you want to link to something only if a user has the permission to do so.

## Basic usage

```bladehtml
<x-forms::conditional-link :url="route('admin.users.index', $organization)" :show-link="$your_condition_boolean" value="10" />
```

## Using `can`

Instead of directly using the `show-link` prop, you can also check for a user permission by using the `can` and `arg` props.

```bladehtml
<x-forms::conditional-link :url="route('admin.users.index', $organization)" can="view" arg="users" value="10" />
```

You can also specify a specific `guard` when using `can`

```bladehtml
<x-forms::conditional-link :url="route('admin.users.index', $organization)" can="view" arg="users" guard="web" value="10" />
```

## Using slot

You can also render your data manually instead of using the `value` prop.

```bladehtml
<x-forms::conditional-link :url="route('admin.users.index', $organization)" can="view" arg="users">
    {{ $organization->users_count }}
</x-forms::conditional-link>
```

## Using model value binding

You can also bind to a model attribute value by using `name` prop when in a model context.

```bladehtml
@model($organization)
<x-forms::conditional-link :url="route('admin.users.index', $organization)" can="view" arg="users" name="users_count" />
@endmodel
```

## Passing additional HTML attributes

HTML attributes will get rendered on the `a` tag. For example, to set the `target` to `_blank`, just use the `target` attribute. 
Remember, if the `show-link` evaluates to `false`, then these extra attributes won't be rendered.

```bladehtml
<x-forms::conditional-link :url="route('admin.users.index', $organization)" can="view" arg="users" value="10" target="_blank" />
```

## Allowed props

The `conditional-link` support the following props:
- `'url'` - (Required) the url to link to.
- `'show-link'` - (Bool) Whether to render as a link or not
- `'value'` - (Optional) Value to render in the link
- `'name'` - Name of the attribute, if using model value binding
- `'can'` - Ability to check for, instead of using `show-link`
- `'arg'` - Argument to pass to `can` method
- `'guard'` - User guard to use when using `can`. By default uses the current guard.
- `'multiline'` - (Bool) If the bound value should be rendered as multiline
- `framework` - Which css framework to use.
