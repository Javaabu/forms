---
title: Introduction
sidebar_position: 1.0
---

# Forms

`javaabu/forms` is a set of Laravel Blade components for forms and admin pages: inputs, selects, dates, files, buttons, cards, tables and more. Each field binds to a model, refills with old input and shows its validation errors, so a form is a few lines of Blade.

```blade
<x-forms::form :model="$article" method="PATCH" :action="route('articles.update', $article)">
    <x-forms::text name="title" :label="__('Title')" required />
    <x-forms::text name="title_dv" label="ސުރުޚީ" thaana />
    <x-forms::select2 name="category_id" :options="\App\Models\Category::query()" />
    <x-forms::date name="published_at" />
    <x-forms::textarea name="body" rows="8" />

    <x-forms::submit>{{ __('Save') }}</x-forms::submit>
</x-forms::form>
```

## What you get

- **The same components in Blade and React.** The React package [`@javaabu/forms`](https://github.com/Javaabu/react-forms) has the same components and attributes, for Inertia pages. See [Parity with @javaabu/forms](./parity.md).
- **Two frameworks.** [`onu`](./frameworks/onu.md) (the default) renders the markup and Tailwind classes of [`@javaabu/onu`](https://github.com/Javaabu/onu), so Blade pages look the same as React pages. [`bootstrap-6`](./frameworks/bootstrap-6.md) renders Bootstrap 6.
- **Binding, old input and errors** for every field: model binding with `:model` or `@model`, old input after a failed request, and errors from the `$errors` bag, with `aria-invalid` set.
- **JavaScript that loads itself.** Searchable and ajax selects, date pickers, file inputs, conditional sections and the Dhivehi keyboard load through [javaabu/manifest](https://github.com/Javaabu/manifest) when a page uses them. No jQuery.
- **Dhivehi and RTL.** Every string has an English and a Dhivehi translation, the layouts use logical (RTL-safe) spacing, and `thaana` fields type Thaana from a Latin keyboard.
- **Overridable.** Publish any view, change icons, classes and defaults in config, or add your own framework.

## Next steps

1. [Install the package](./installation-and-setup.md).
2. Build a form with the [form](./basic-usage/forms.md) and [input](./basic-usage/inputs-and-textarea.md) components.
3. Coming from v1? Read [Upgrading from v1](./upgrading.md).
