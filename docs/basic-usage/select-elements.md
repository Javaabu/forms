---
title: Select
sidebar_position: 6
---

# Select

`<x-forms::select>` renders a native `<select>` with its label, help text and errors. For search, AJAX options, tags or dependent selects, use [Select2](./select2.md), which takes every attribute on this page.

## Options from an array

Pass `value => label` pairs to `options`:

```blade
<x-forms::select name="atoll" label="އަތޮޅު" :options="[
    'K' => 'ކާފު އަތޮޅު',
    'S' => 'އައްޑޫ އަތޮޅު',
]" />
```

A list without keys uses the positions as values (`0`, `1`, `2`, …):

```blade
<x-forms::select name="size" :options="['S', 'M', 'L']" />
```

A `Collection` works the same way:

```blade
<x-forms::select name="country" :options="Country::query()->pluck('name', 'id')" />
```

## Options from an enum

Pass the enum's `value => label` array. Enums that use `Javaabu\Helpers\Enums\NativeEnumsTrait` have `labels()`:

```blade
<x-forms::select name="status" label="ހާލަތު" :options="ArticleStatuses::labels()" />
```

A bound enum attribute selects the option with the enum's `value`.

## Options from a query

Pass a query builder, and the component plucks the options from it:

```blade
<x-forms::select name="category" :options="Category::query()->orderBy('name')" />
```

By default the model's key is the value and `name` is the label. Change them with `id-field` and `name-field`:

```blade
<x-forms::select name="island" :options="Island::query()" name-field="name_dv" id-field="code" />
```

When `name-field` or `id-field` is an accessor, or the model uses `javaabu/translatable`, the models are loaded and the accessor is read on each one, so the query still works:

```blade
<x-forms::select name="category" :options="Category::query()" name-field="formatted_name" />
```

## Options in the slot

Leave out `options` and write the `<option>` tags yourself:

```blade
<x-forms::select name="priority">
    <option value="low">{{ __('Low') }}</option>
    <option value="high">{{ __('High') }}</option>
</x-forms::select>
```

The slot is used only when `options` is empty. Options in the slot aren't selected for you; set `selected` on them yourself.

## Placeholder

`placeholder` adds a first option with an empty value, selected when nothing else is:

```blade
<x-forms::select name="atoll" :options="$atolls" placeholder="އަތޮޅެއް ޚިޔާރުކުރައްވާ" />

{{-- Use the label as the placeholder --}}
<x-forms::select name="atoll" label="އަތޮޅު" :options="$atolls" show-placeholder />
```

Leave out `placeholder` on a plain `multiple` select: the empty option can be selected along with the others.

## Selected value

The selected option comes from old input, then `default`, then the bound model:

```blade
<x-forms::form :model="$address">
    {{-- selects $address->atoll, or "K" when the address has none --}}
    <x-forms::select name="atoll" :options="$atolls" default="K" />
</x-forms::form>
```

- A bound `Model` selects its key, or its `id-field` attribute.
- A bound enum selects its `value`.
- Values are compared loosely, so a bound `0` or `false` selects the option with key `0`.

## Multiple selection

Add `multiple` and end the name with `[]`. `default` and the bound value should be arrays or collections:

```blade
<x-forms::select name="atolls[]" :options="$atolls" multiple :default="['K', 'S']" />
```

When the bound value is a collection of models, set `id-field` to the attribute to select by, or use [`relation`](#selecting-from-a-relation):

```blade
<x-forms::select name="categories[]" :options="Category::query()" multiple id-field="id" />
```

### The sync field

A multiple select also renders a hidden `sync_<name>` input with the value `1`, so the request says the field was on the form even when nothing is selected (browsers don't submit an empty multiple select). Use it to detach every related model:

```php
if ($request->has('sync_categories')) {
    $article->categories()->sync($request->input('categories', []));
}
```

- `sync-field-name` changes the hidden input's name.
- `exclude-sync-field` leaves it out.
- It's left out of `disabled` selects, which aren't submitted.

```blade
<x-forms::select name="tags[]" :options="$tags" multiple sync-field-name="update_tags" />
```

## Selecting from a relation

Add `relation` when the field name is a relation on the bound model. The selected keys are read from the relation without loading the related models:

```blade
<x-forms::form :model="$article">
    {{-- BelongsTo: $article->category_id --}}
    <x-forms::select name="category" :options="Category::query()" relation />

    {{-- BelongsToMany or MorphMany: the attached keys --}}
    <x-forms::select name="tags[]" :options="Tag::query()" multiple relation />
</x-forms::form>
```

The relation method is the camel-case name (`name="related_posts[]"` reads `relatedPosts()`). Without `relation`, `name="category"` reads `$article->category` (loading the model) and selects its key.

## Keeping typed values

`tags` keeps values from old input that aren't in `options`, so a value the user added (with [Select2 tags](./select2.md#letting-users-add-options)) survives a failed validation. On a plain select it has no other effect.

## Text before or after the select

`prepend` and `append` slots work as on [inputs](./inputs-and-textarea.md#text-before-or-after-the-control):

```blade
<x-forms::select name="code" :options="$codes">
    <x-slot:prepend>+960</x-slot:prepend>
</x-forms::select>
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name. End it with `[]` for `multiple`. |
| `label` | `string` | from `name` | Label text. |
| `options` | `array`, `Collection` or query builder | `[]` | `value => label` pairs, or a query to pluck them from. |
| `placeholder` | `string` | `''` | Text of an empty first option. |
| `show-placeholder` | `bool` | `false` | Uses the label as the placeholder when `placeholder` is empty. |
| `model` | `mixed` | bound model | Model to read the selected value from. `false` turns binding off. |
| `default` | `mixed` | `null` | Selected value(s). Wins over the bound model. |
| `multiple` | `bool` | `false` | Allows selecting several options. |
| `relation` | `bool` | `false` | Reads the selected keys from the relation named `name`. |
| `name-field` | `string` | `'name'` | Attribute used for labels when `options` is a query. |
| `id-field` | `string` | model key | Attribute used for values when `options` is a query, and for a bound model or collection. |
| `disabled` | `bool` | `false` | Disables the select and leaves out the sync field. |
| `exclude-sync-field` | `bool` | `false` | Leaves out the `sync_<name>` hidden input. |
| `sync-field-name` | `string` | `sync_<name>` | Name of the sync hidden input. |
| `tags` | `bool` | `false` | Keeps old input values that aren't in `options`. |
| `required` | `bool` | `false` | Adds `required` and the required marker. |
| `show-label` | `bool` | `true` | `false` removes the label and field wrapper. |
| `show-errors` | `bool` | `true` | Shows errors and marks the select invalid. |
| `inline` | `bool` | `false` | Label beside the select. |
| `inline-label-class` | `string` | config | Classes for the label column. |
| `inline-input-class` | `string` | config | Classes for the control column. |
| `floating` | `bool` | `false` | Floating label (`bootstrap-6` only). |
| `form-group-class` | `string` | `''` | Classes on the field wrapper. |
| `show-js-errors` | `bool` | `false` | Adds an empty error list for JavaScript validation. |
| `is-select2` | `bool` | `false` | Used by `select2`. Use `<x-forms::select2>` instead. |
| `is-ajax` | `bool` | `false` | With a query, loads only the selected options. Used by `select2`. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the `<select>`.

Slots: default (options, when `options` is empty), `help`, `prepend`, `append`.

## React

```jsx
import { Select } from "@javaabu/forms"

<Select name="atoll" label="އަތޮޅު" options={atolls} placeholder="އަތޮޅެއް ޚިޔާރުކުރައްވާ" />
<Select name="tags[]" options={tags} multiple />
```

See [Parity](../parity.md).
