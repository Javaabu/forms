---
title: Model binding and default values
sidebar_position: 2
---

# Model binding and default values

Fields fill themselves from a bound model, from old input after a failed validation, and from a `default`. You don't pass `value` to inputs yourself.

## Binding a whole form

Pass the model to the form. Each field reads the attribute with its `name`:

```blade
<x-forms::form method="PATCH" :action="route('articles.update', $article)" :model="$article">
    {{-- $article->title --}}
    <x-forms::text name="title" label="ސުރުހީ" />

    {{-- $article->body --}}
    <x-forms::textarea name="body" />
</x-forms::form>
```

The model can be an Eloquent model, an array or any object. Values are read with `data_get()`, so arrays work too:

```blade
<x-forms::form method="GET" :model="request()->query()">
    <x-forms::text name="search" :show-label="false" />
</x-forms::form>
```

:::note
The model is bound only inside the form: fields after `</x-forms::form>` don't read it. The same goes for `table.row` and `infolist`.
:::

## Binding without a form

Use the `@model` directive to bind a model for part of a view, for example inside a form you open yourself or around [text entries](./text-entry.md):

```blade
@model($article)
    <x-forms::text name="title" />
    <x-forms::textarea name="body" />
@endmodel
```

`@endmodel` restores the binding that was active before, so bindings can be nested:

```blade
<x-forms::form method="PATCH" :action="route('users.update', $user)" :model="$user">
    <x-forms::text name="name" label="ނަން" />

    @model($user->profile)
        {{-- $user->profile->bio --}}
        <x-forms::textarea name="bio" thaana />
    @endmodel

    {{-- back to $user->email --}}
    <x-forms::email name="email" />
</x-forms::form>
```

## Binding one field

Every field takes a `model` attribute. It reads from that model instead of the bound one, without changing the binding for other fields:

```blade
<x-forms::form :model="$article">
    <x-forms::text name="title" />

    {{-- $category->name --}}
    <x-forms::text name="name" :model="$category" />

    {{-- not bound at all --}}
    <x-forms::textarea name="note" :model="false" />
</x-forms::form>
```

## Default values

`default` is the value a field shows when there is no old input and the model has no value (the attribute is `null`, or there is no model):

```blade
<x-forms::text name="island" label="ރަށް" default="މާލެ" />
<x-forms::number name="quantity" :default="1" />
<x-forms::select name="atoll" :options="$atolls" default="K" />
```

## Which value wins

| Component | Order |
| --- | --- |
| Inputs (`text`, `email`, `number`, …), `textarea`, `wysiwyg`, `date`, `datetime`, `time`, `file`, `image` | 1. old input<br />2. the bound model's value, when it isn't `null`<br />3. `default` |
| `select`, `select2` | 1. old input<br />2. `default`, when it isn't `null`<br />3. the bound model's value |
| `checkbox`, `radio` | See [Checkbox and radio](./checkbox.md#how-the-checked-state-is-decided) |

Two more rules:

- `password` inputs are never filled.
- `textarea` and `wysiwyg` take a `value` attribute, which replaces everything above, including old input.

## Old input

After a failed validation, Laravel flashes the submitted input to the session and every field shows what the user typed. Nothing needs to be set up. Field names with brackets are read with dots, so `address[city]` reads `old('address.city')`.

## Nested names

Bracket names read nested values from the model too:

```blade
<x-forms::form :model="$order">
    {{-- $order->address['city'] or $order->address->city --}}
    <x-forms::text name="address[city]" label="ރަށް" />
</x-forms::form>
```

The field gets the id `address-city`, and its errors are read from `address.city`.

## Enums

A field bound to a backed enum uses the enum's `value`:

```php
enum ArticleStatuses: string
{
    case Draft = 'draft';
    case Published = 'published';
}
```

```blade
<x-forms::form :model="$article">
    {{-- the "draft" option is selected when $article->status is ArticleStatuses::Draft --}}
    <x-forms::select name="status" :options="ArticleStatuses::labels()" />
</x-forms::form>
```

`labels()` comes from `Javaabu\Helpers\Enums\NativeEnumsTrait`. Any `value => label` array works. To show an enum's label rather than edit it, use [`<x-forms::text-entry>`](./text-entry.md).

## Dates

Date fields bound to an Eloquent date attribute show it in the picker's format: `Y-m-d` for `date`, `Y-m-d H:i` for `datetime`, `H:i` for `time`. Set `date-format` for another format:

```blade
<x-forms::form :model="$article">
    <x-forms::date name="published_at" />
    <x-forms::time name="starts_at" date-format="H:i:s" />
</x-forms::form>
```

To format dates with the model's own casts instead (`'published_at' => 'date:Y-m-d'`), set `use_eloquent_date_casting` to `true` in `config/forms.php`. See [Dates and times](./dates.md).

## Relations

A select bound to a relation selects the related keys when you add `relation`:

```blade
<x-forms::form :model="$article">
    {{-- BelongsTo: reads $article->category_id --}}
    <x-forms::select name="category" :options="Category::query()" relation />

    {{-- BelongsToMany or MorphMany: reads the attached ids --}}
    <x-forms::select name="tags[]" :options="Tag::query()" multiple relation />
</x-forms::form>
```

Without `relation`, a select bound to a related model uses that model's key, which loads the relation. See [Select](./select-elements.md#selecting-from-a-relation).

## Media library files

[File and image inputs](./file-inputs.md) bound to a model that uses `spatie/laravel-medialibrary` show the first file in the media collection with the field's name.

## React

```jsx
import { Form, Text, Textarea } from "@javaabu/forms"

<Form model={user}>
  <Text name="name" label="ނަން" />
  <Textarea name="bio" thaana />
</Form>
```

`:model` on a form or field is the `model` prop. `@model` / `@endmodel` is React's `Model` component. React reads old input and errors from Inertia's page props. See [Parity](../parity.md).
