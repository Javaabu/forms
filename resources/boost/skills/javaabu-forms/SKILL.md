---
name: javaabu-forms
description: Build Laravel Blade forms, listing pages and details pages with javaabu/forms components (<x-forms::text>, <x-forms::select2>, <x-forms::table>, …) for the Onu or Bootstrap 6 frameworks. Use whenever the project requires javaabu/forms and the task creates or changes a Blade form or admin view, binds a model to a form, shows validation errors, adds selects, dates, files, buttons, cards, tables, filters or pagination, styles or overrides these components, or handles Dhivehi, Thaana or RTL in Blade forms.
license: MIT
metadata:
  author: Javaabu
---

# Building Blade views with javaabu/forms

The docs ship with the package: `vendor/javaabu/forms/llms.txt` lists every page in `vendor/javaabu/forms/docs/`. Every component's attributes and defaults are in [references/components.md](references/components.md).

## A form

```blade
<x-forms::form :model="$article" method="PATCH" :action="route('admin.articles.update', $article)" files>
    <x-forms::text name="title" :label="__('Title')" required />
    <x-forms::text name="title_dv" label="ސުރުޚީ" thaana />
    <x-forms::select2 name="category_id" :options="\App\Models\Category::query()" required />
    <x-forms::select name="status" :options="\App\Enums\ArticleStatuses::labels()" />
    <x-forms::date name="published_at" />
    <x-forms::checkbox name="is_featured" />
    <x-forms::image name="featured_image" collection="featured_image" />
    <x-forms::textarea name="body" rows="8" wysiwyg />

    <x-forms::submit>{{ __('Save') }}</x-forms::submit>
</x-forms::form>
```

- `name` drives everything: the id (`address[city]` → `address-city`), the label (`first_name` → `First Name`, through `__()`), the bound value, old input and errors (`address.city`).
- The value comes from old input, then the bound model (`:model`, `@model`), then `default` (selects: old input, `default`, then the model). Don't write `value="{{ old('title', $article->title) }}"`.
- `method` can be `PUT`, `PATCH` or `DELETE`; the form spoofs it and adds `@csrf`.
- Errors show under each field automatically. Add `summary` to the form for a list at the top.

## Rules

- Use the components; don't write `<input class="form-control">` or Onu/Bootstrap classes by hand. Pass extra classes with `class` (the control) or `form-group-class` (the wrapper).
- Attributes are kebab-case (`show-label`, `inline-label-class`); pass PHP values with `:` (`:options="$islands"`, `:required="$is_required"`). Boolean attributes can be bare (`required`, `inline`, `multiple`).
- Pass options as a `[value => label]` array (for enums, their labels array), a collection, or an Eloquent query (`App\Models\Atoll::query()`). Queries use `name`/`id` unless you set `name-field`/`id-field`. Bound backed enums and models select the right option.
- Multiple selects submit `name[]` plus a `sync_name` hidden field, so an empty selection still syncs. Keep it unless you handle that yourself (`exclude-sync-field`).
- For Dhivehi free text, add `thaana`. Labels and options can be Thaana. Use `__()` for every user-facing string, and add Dhivehi to `lang/dv.json`.
- Colours use Bootstrap names in both frameworks: `color="danger"`, `color="outline-secondary"`, `type="success"` (alerts), `color="warning"` (status).
- Pick the framework in `config/forms.php` (`onu` default, `bootstrap-6`), not per view, unless one component must differ (`framework="bootstrap-6"`).
- JS loads by itself through javaabu/manifest. Don't add jQuery, Select2, flatpickr or js-utilities script tags. Keep `@stack('scripts')` in the layout for Google Maps and TinyMCE.
- To change markup, publish one view (`php artisan forms:publish-view`) rather than all of them.

## Common tasks

| Task | Use |
| --- | --- |
| Searchable or ajax select | `<x-forms::select2 name="island_id" is-ajax :ajax-url="route('api.islands.index')" />` |
| Dependent selects | parent `child="#island_id" is-first`, child `:ajax-url="route('api.islands.index')" filter-field="atoll"` (the parent's value is sent as `filter[atoll]`) |
| Show a section for a value | `<x-forms::conditional-wrapper enable-elem="#type" enable-value="business" hide-fields>` |
| Date, date-time, time | `<x-forms::date>`, `<x-forms::datetime>`, `<x-forms::time>` |
| Read-only details page | `<x-forms::infolist :model="$article">` with `<x-forms::text-entry name="title" />` |
| Listing page | `<x-forms::table>` with `x-forms::table.row`/`.cell`, `<x-forms::filter>`, `<x-forms::per-page />`, `<x-forms::pagination :paginator="$articles" />` |
| Buttons | `<x-forms::submit>`, `<x-forms::link-button :url="…" color="light">`, `size="sm"`, `start-icon="plus"` |
| Icons | `<x-forms::icon name="calendar" />` (bundled Lucide names) or icon-font classes |

## Common mistakes

- Using `<x-forms::input type="select">`: use `<x-forms::select>`.
- Passing a model to every field: bind once on the form.
- Translating the label inside `name` (`name="{{ __('title') }}"`): `name` is the field name; pass `label`.
- Writing `@error` blocks next to fields: the components already show errors.
- Expecting `floating` labels in Onu: Onu has none, so the label sits above.
- Hard-coding `dir="rtl"` on a field: use `thaana` (fields) or set `dir` on `<html>` (pages).
- Mixing Bootstrap 5 classes (`form-select`, `btn-primary`, `col-md-6`) into Bootstrap 6 views: Bootstrap 6 uses `form-control` on selects, `btn-solid theme-primary`, `md:col-6`.

## React

Inertia pages use `@javaabu/forms` with the same components in PascalCase (`<Text name="title" />`, `<Select2 … />`) and camelCase props. See `vendor/javaabu/forms/docs/parity.md`.
