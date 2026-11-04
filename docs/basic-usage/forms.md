---
title: Forms
sidebar_position: 1
---

# Forms

`<x-forms::form>` renders a `<form>` with the CSRF token, method spoofing and, optionally, a bound model and an error summary. Fields inside it read their values from the bound model and old input, and show their validation errors.

## Creating a form

```blade
<x-forms::form :action="route('articles.store')">
    <x-forms::text name="title" label="ސުރުހީ" required />
    <x-forms::textarea name="body" :label="__('Body')" />

    <x-forms::submit>{{ __('Save') }}</x-forms::submit>
</x-forms::form>
```

Any attribute the component doesn't use, such as `action`, `id`, `class` or `data-*`, is added to the `<form>` tag.

The form uses `POST` by default and adds the CSRF field (`@csrf`) for every method except `GET`, `HEAD` and `OPTIONS`.

## Using PUT, PATCH or DELETE

Set `method`. Browsers only submit `GET` and `POST`, so for `PUT`, `PATCH` and `DELETE` the form is sent as `POST` with a hidden `_method` field, which Laravel reads as the real method.

```blade
<x-forms::form method="PUT" :action="route('articles.update', $article)" :model="$article">
    <x-forms::text name="title" label="ސުރުހީ" />

    <x-forms::submit>{{ __('Update') }}</x-forms::submit>
</x-forms::form>

<x-forms::form method="DELETE" :action="route('articles.destroy', $article)">
    <x-forms::submit color="danger">{{ __('Delete') }}</x-forms::submit>
</x-forms::form>
```

The first form renders:

```html
<form method="POST" action="https://example.test/articles/1" data-focus-on-error>
    <input type="hidden" name="_token" value="…" autocomplete="off">
    <input type="hidden" name="_method" value="PUT">
    …
</form>
```

## Uploading files

Add `files` to set `enctype="multipart/form-data"`, which file inputs need:

```blade
<x-forms::form :action="route('articles.store')" files>
    <x-forms::file name="attachment" label="ފައިލް" />
</x-forms::form>
```

See [File inputs](./file-inputs.md).

## Filling the form from a model

Pass the model to `model`. Every field in the form reads its value from the attribute with the same name:

```blade
<x-forms::form method="PATCH" :action="route('articles.update', $article)" :model="$article">
    <x-forms::text name="title" />
    <x-forms::select name="category" :options="$categories" relation />
</x-forms::form>
```

Model binding, value precedence, enums, dates and relations are covered in [Model binding](./model-binding.md).

## Showing an error summary

Add `summary` to list every validation error at the top of the form. Each message links to its field.

```blade
<x-forms::form :action="route('contacts.store')" summary>
    <x-forms::text name="name" label="ނަން" required />
    <x-forms::email name="email" required />
</x-forms::form>
```

The title defaults to "Please correct the errors below." (translated, see `error_summary_title` in `lang/{en,dv}/strings.php`). Change it for one form with `summary-title`:

```blade
<x-forms::form :action="route('contacts.store')" summary summary-title="ތިރީގައިވާ ކުށްތައް ރަނގަޅުކުރައްވާ">
    …
</x-forms::form>
```

`error-bag` sets which error bag the summary reads. Fields always read the `default` bag. To put the summary somewhere else, or to show field names in front of the messages, use [`<x-forms::error-summary>`](./labels-help-and-errors.md#error-summary) on its own.

## Focusing the first error

After a failed submission, the form moves focus to its error summary or, without one, to the first invalid field (`aria-invalid="true"`). This is on by default: the form gets a `data-focus-on-error` attribute, which the package's JavaScript picks up. Turn it off with `:focus-on-error="false"`:

```blade
<x-forms::form :action="route('search')" method="GET" :focus-on-error="false">
    …
</x-forms::form>
```

The script loads with the components. See [Assets](../advanced-usage/assets.md).

## Disabling the submit button while sending

[`<x-forms::submit>`](./buttons.md#submit-buttons) shows a spinner and disables itself when the form submits, so it can't be pressed twice. This needs no setup.

## Splitting a form across partials

When the opening and closing tags have to live in different files, use `<x-forms::form-open>` and `<x-forms::form-close>` instead:

```blade
{{-- resources/views/admin/articles/_header.blade.php --}}
<x-forms::form-open method="PATCH" :action="route('admin.articles.update', $article)" :model="$article" files />

{{-- resources/views/admin/articles/_fields.blade.php --}}
<x-forms::text name="title" label="ސުރުހީ" />

{{-- resources/views/admin/articles/_footer.blade.php --}}
<x-forms::submit>{{ __('Save') }}</x-forms::submit>
<x-forms::form-close />
```

`form-open` takes `method`, `model` and `files`, and passes other attributes to the `<form>` tag. It doesn't render an error summary and doesn't add `data-focus-on-error`; add [`<x-forms::error-summary>`](./labels-help-and-errors.md#error-summary) yourself if you need one.

## Choosing the framework

Components render for the framework set in `config/forms.php` (`onu` by default). Every component also takes a `framework` attribute:

```blade
<x-forms::form :action="route('login')" framework="bootstrap-6">
    <x-forms::email name="email" framework="bootstrap-6" />
</x-forms::form>
```

`framework` applies to the component it's on, not to the fields inside it. To switch every component for a group of routes, use the `forms` middleware:

```php
Route::middleware('forms:bootstrap-6')->group(function () {
    // ...
});
```

See [Configuration](../advanced-usage/configuration.md#switching-framework-per-request).

## Attributes

### `form`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `method` | `string` | `'POST'` | `GET`, `POST`, `PUT`, `PATCH` or `DELETE`. `PUT`, `PATCH` and `DELETE` are sent as `POST` with a `_method` field. |
| `model` | `mixed` | `null` | Model, array or object the fields read their values from. |
| `files` | `bool` | `false` | Adds `enctype="multipart/form-data"`. |
| `summary` | `bool` | `false` | Shows an error summary at the top of the form. |
| `summary-title` | `string` | `''` | Title of the error summary. Defaults to the `error_summary_title` string. |
| `focus-on-error` | `bool` | `true` | Focuses the error summary or the first invalid field after a failed submission. |
| `error-bag` | `string` | `'default'` | Error bag the summary reads. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the `<form>` tag. The default slot is the form's content.

### `form-open`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `method` | `string` | `'POST'` | As on `form`. |
| `model` | `mixed` | `null` | As on `form`. |
| `files` | `bool` | `false` | As on `form`. |

`form-close` takes no attributes and renders `</form>`.

## React

```jsx
import { Form, Text, Submit } from "@javaabu/forms"

<Form model={article} summary summaryTitle="ތިރީގައިވާ ކުށްތައް ރަނގަޅުކުރައްވާ">
  <Text name="title" label="ސުރުހީ" required />
  <Submit>Save</Submit>
</Form>
```

React's `Form` submits through Inertia and has its own submission props (`onSubmit`, `onSuccess`, …). Its `summary` defaults to `true`; Blade's defaults to `false`. `form-open` and `form-close` have no React equivalent. See [Parity](../parity.md).
