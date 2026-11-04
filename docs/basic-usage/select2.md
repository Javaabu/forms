---
title: Select2
sidebar_position: 7
---

# Select2

`<x-forms::select2>` is a [select](./select-elements.md) with a search box, a clear button, options loaded over AJAX, tags and dependent (cascading) selects. It keeps the v1 name, but v2 runs it with [Tom Select](https://tom-select.js.org) instead of Select2 and jQuery. The script and its styles load with the component (see [Assets](../advanced-usage/assets.md)).

It takes every attribute of [`select`](./select-elements.md#attributes): `options` from arrays, enums or queries, `multiple`, `relation`, `name-field`, `id-field`, the sync field, `default` and model binding all work the same way.

## Basic usage

```blade
<x-forms::select2 name="atoll" label="އަތޮޅު" :options="$atolls" />
```

The select is clearable and shows "Nothing Selected" (translated) until something is chosen. Change the text with `placeholder`.

## Search and clear

- `hide-search` removes the search box, for short lists.
- `:clearable="false"` (or the v1 name `:allow-clear="false"`) removes the clear button, and the "Nothing Selected" placeholder with it.

```blade
<x-forms::select2 name="status" :options="ArticleStatuses::labels()" hide-search :clearable="false" />
```

## Multiple selection

```blade
<x-forms::select2 name="islands[]" label="ރަށްތައް" :options="$islands" multiple />
```

Selected items show as removable chips. Like a plain multiple select, it adds a `sync_<name>` hidden input (see [The sync field](./select-elements.md#the-sync-field)).

## Letting users add options

`tags` lets users type values that aren't in the list. Values they added are kept after a failed validation:

```blade
<x-forms::select2 name="keywords[]" :options="$keywords" multiple tags />
```

## Loading options over AJAX

For long lists, load the options from an endpoint as the user types. Add `is-ajax` and `ajax-url`, and pass a query for `options`: only the selected options are loaded from it, so the current value shows before the user searches.

```blade
<x-forms::form :model="$article">
    <x-forms::select2
        name="author"
        :options="User::query()"
        :ajax-url="route('api.users.index')"
        name-field="name"
        is-ajax
        relation
    />
</x-forms::form>
```

Searching starts after one character. Change it with `min-chars`:

```blade
<x-forms::select2 name="island" :options="Island::query()" :ajax-url="route('api.islands.index')" is-ajax min-chars="3" />
```

### What the endpoint receives and returns

The script sends a `GET` request with Laravel's AJAX headers and these query parameters:

| Parameter | Value |
| --- | --- |
| `filter[search]` | The text typed. |
| `fields` | `{id-field},{name-field}`, for example `id,name`. |
| `page` | The page number, as the user scrolls. |
| `per_page` | Only when the select has a `data-per-page` attribute. |
| `filter[{filter-field}]` | The parent's value, for [filtered selects](#filtering-by-another-select). |

It also sends empty `append` and `include` parameters. The names follow `spatie/laravel-query-builder` (`filter`, `fields`), so an endpoint built with it can read them with an allowed `search` filter.

The endpoint returns a JSON array of items or a Laravel paginated response (`data` and `next_page_url`). Each item's `id-field` (default `id`) becomes the value and its `name-field` (default `name`) the label.

## Filtering by another select

To filter an AJAX select by another field's value, point `parent` at that field and set `filter-field` to the filter name:

```blade
<x-forms::select2 name="atoll" label="އަތޮޅު" :options="Atoll::query()" />

<x-forms::select2
    name="island"
    label="ރަށް"
    :options="Island::query()"
    :ajax-url="route('api.islands.index')"
    parent="#atoll"
    filter-field="atoll"
    is-ajax
/>
```

Each search sends `filter[atoll]` with the atoll's value. The island select is disabled while no atoll is selected, and clears when the atoll changes. The URL can also take the value: `ajax-url="/api/atolls/:value/islands"` replaces `:value` with the parent's value.

## Cascading selects

With `child`, choosing a value loads all of the next select's options at once and replaces them. Use it for short dependent lists, chained as deep as you need:

```blade
<x-forms::form :model="$address">
    <x-forms::select2 name="country" :options="Country::query()" child="#state" is-first />

    <x-forms::select2
        name="state"
        :options="State::where('country_id', $address->country_id)"
        :ajax-url="route('api.states.index')"
        child="#city"
        filter-field="country"
    />

    <x-forms::select2
        name="city"
        :options="City::where('state_id', $address->state_id)"
        :ajax-url="route('api.cities.index')"
        filter-field="state"
        relation
    />
</x-forms::form>
```

1. The parent names its child with `child` (a selector).
2. The child has the `ajax-url` to load from and the `filter-field` its parent's value is sent as (`filter[country]=…`, with `per_page=-1`).
3. `is-first` on the first select loads its children when the page loads, so a pre-filled form shows the right options.

Pass the child's current options from the server too (`State::where(…)`), so the selected value shows before any request.

### Showing a text field when there are no options

`fallback` names a field to show instead of the child when the request returns no options. The select is disabled and hidden, and the fallback is enabled and shown. Give the fallback the same `name`, so the server receives one value either way:

```blade
<x-forms::select2
    name="city"
    :options="City::where('state_id', $address->state_id)"
    :ajax-url="route('api.cities.index')"
    filter-field="state"
    fallback="#city-name"
/>

<x-forms::text name="city" id="city-name" :placeholder="__('Type the city name')" />
```

### Changing the URL with the parent's value

When the parent decides which endpoint the child searches, give the child a JSON object of URLs and point the parent at it with `ajax-child`:

```blade
<x-forms::select2 name="entity_type" :options="['users' => __('Users'), 'posts' => __('Posts')]" ajax-child="#entity" />

<x-forms::select2
    name="entity_id"
    id="entity"
    :ajax-url="json_encode([
        'users' => route('api.users.index'),
        'posts' => route('api.posts.index'),
    ])"
    selected-url="users"
    is-ajax
/>
```

`selected-url` is the key to start with. The child resets when the key changes.

## Icon selects

`is-icon-select` shows an icon beside each option. The option value is the icon name, rendered as `<i class="{icon-prefix} {icon-prefix}-{value}">`:

```blade
<x-forms::select2 name="icon" :options="$icons" is-icon-select icon-prefix="fa" />
```

`Javaabu\Forms\Support\Icons\FontAwesomeIcons::getIcons()` returns a list of Font Awesome names to use as options.

## Inside a modal

By default the dropdown is placed next to the select. Inside a modal, set `parent-modal` to the modal so the dropdown is placed inside it and isn't cut off or hidden behind it:

```blade
<x-forms::modal id="assign-modal" title="ހަވާލުކުރޭ">
    <x-forms::select2 name="user" :options="$users" parent-modal="#assign-modal" />
</x-forms::modal>
```

## Attributes

The attributes of [`select`](./select-elements.md#attributes) (except `is-select2`), and:

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `placeholder` | `string` | "Nothing Selected" when clearable | Text shown when nothing is selected. |
| `clearable` | `bool` | `true` | Shows a clear button. Alias of `allow-clear`; `clearable` wins when both are set. |
| `allow-clear` | `bool` | `true` | The v1 name of `clearable`. |
| `hide-search` | `bool` | `false` | Removes the search box (single selects). |
| `tags` | `bool` | `false` | Lets users add options. |
| `is-ajax` | `bool` | `false` | Searches `ajax-url` as the user types. With a query for `options`, only the selected options are loaded. |
| `ajax-url` | `string` | `''` | Endpoint for options, or a JSON object of endpoints (with `selected-url`). `:value` is replaced with the parent's value. |
| `selected-url` | `string` | `''` | Key of the endpoint to use when `ajax-url` is a JSON object. |
| `min-chars` | `int` | `1` (AJAX) | Characters to type before searching. |
| `parent` | `string` | `''` | Selector of the field that filters this AJAX select. |
| `filter-field` | `string` | `''` | Name the parent's value is sent as, `filter[{filter-field}]`. |
| `child` | `string` | `''` | Selector of the select whose options load when this one changes. |
| `is-first` | `bool` | `false` | Loads the children's options when the page loads. |
| `fallback` | `string` | `''` | Selector of a field shown when this child has no options. |
| `ajax-child` | `string` | `''` | Selector of an AJAX select whose endpoint this select's value picks. |
| `is-icon-select` | `bool` | `false` | Shows an icon for each option. |
| `icon-prefix` | `string` | `''` | Icon font prefix for icon selects, for example `fa`. |
| `parent-modal` | `string` | `''` | Selector of the element to place the dropdown in. |

## React

```jsx
import { Select2 } from "@javaabu/forms"

<Select2 name="atoll" label="އަތޮޅު" options={atolls} />
<Select2
  name="island"
  label="ރަށް"
  isAjax
  ajaxUrl="/api/islands"
  parent="#atoll"
  filterField="atoll"
  minChars={2}
/>
```

`is-first`, `is-icon-select`, `icon-prefix` and `parent-modal` are Blade only. React's dropdowns render in a portal, so they need no `parentModal`. See [Parity](../parity.md).
