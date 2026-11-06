---
title: Tables and listings
sidebar_position: 22
---

# Tables and listings

These components build an index page: a filter card with search and per-page fields, a table with select-all checkboxes and bulk actions, sortable headings, an empty state, and pagination.

## A complete index page

```php
public function index(Request $request): View
{
    $search = $request->string('search')->toString();
    $per_page = $request->integer('per_page', 20);

    $users = User::query()
        ->when($search, fn (Builder $query) => $query->where('name', 'like', "%{$search}%"))
        ->latest()
        ->paginate($per_page)
        ->withQueryString();

    return view('admin.users.index', [
        'users' => $users,
    ]);
}
```

```blade
<x-forms::form method="GET" :action="route('admin.users.index')" :model="request()->query()" id="filter">
    <x-forms::filter>
        <div class="grid gap-4 md:grid-cols-3">
            <x-forms::text name="search" label="ހޯދާ" :show-errors="false" />
            <x-forms::per-page show-label />
            <x-forms::filter-submit :cancel-url="route('admin.users.index')" />
        </div>
    </x-forms::filter>
</x-forms::form>

@if ($users->isNotEmpty())
    <x-forms::table model="users">
        <x-slot:bulk-form :action="route('admin.users.bulk')">
            <x-forms::bulk-actions model="users" :actions="[
                'approve' => __('Approve'),
                'delete' => __('Delete'),
            ]" />
        </x-slot:bulk-form>

        <x-slot:headers>
            <x-forms::table.heading label="ނަން" sortable="name" />
            <x-forms::table.heading :label="__('Email')" />
            <x-forms::table.heading :label="__('Status')" />
        </x-slot:headers>

        <x-slot:rows>
            @foreach ($users as $user)
                <x-forms::table.row :model="$user" name="users">
                    <x-forms::table.cell name="name" label="ނަން" />
                    <x-forms::table.cell name="email" />
                    <x-forms::table.cell name="status" />
                </x-forms::table.row>
            @endforeach
        </x-slot:rows>

        <x-slot:pagination>
            <x-forms::pagination :paginator="$users" />
        </x-slot:pagination>
    </x-forms::table>
@else
    <x-forms::no-items :create-action="route('admin.users.create')" :model="App\Models\User::class" model-type="users" />
@endif
```

## Table

`<x-forms::table>` renders a responsive table with a select-all checkbox in the header.

- Put heading cells in the `headers` slot and rows in the `rows` slot.
- `model` names the checkbox group. The header checkbox has `data-all="{model}"` and checks every row checkbox with `data-check="{model}"`, and shows an indeterminate state when only some are checked. Below the `lg` breakpoint a "Select All" checkbox shows above the table.
- `no-checkbox` removes the checkbox column. Set it on each row too.
- `striped` stripes the rows. `table-class` adds classes to the `<table>`.
- The `pagination` slot renders after the table. `no-pagination` leaves it out.

### Bulk actions

Put a `bulk-form` slot on the table to wrap the table in a form that posts to the slot's `action`. Its content renders above the table; `<x-forms::bulk-actions>` gives a select of actions and an Apply button:

```blade
<x-slot:bulk-form :action="route('admin.users.bulk')">
    <x-forms::bulk-actions model="users" :actions="['approve' => __('Approve'), 'delete' => __('Delete')]" />
</x-slot:bulk-form>
```

The form posts with `POST` (the slot's `method` isn't used) and sends `action`, the checked ids as `users[]`, and `redirect` (the current URL). To leave out the bulk form, leave out the slot.

### More slots

| Slot | Where |
| --- | --- |
| `before-table` | Above the table, inside the wrapper. |
| `before-headers` | In `<thead>`, before the heading row. |
| `after-headers` | In `<thead>`, after the heading row. |
| `tbody-open` | Replaces the opening `<tbody>` tag, for a `<tbody>` with your own attributes. |
| `after-tbody` | After `</tbody>`. |

## Rows

```blade
<x-forms::table.row :model="$user" name="users">
    …
</x-forms::table.row>
```

- `model` binds the model for the row's cells.
- `name` is the checkbox group and the checkbox's `name` (`users[]`). Use the table's `model`. Without it, the name is the plural of the model's morph class, so set it unless you use a morph map.
- The checkbox value is `model-id`, which defaults to the model's key.
- The row's id is `{name}-{model-id}-row` (or `row-id`), and its checkbox's id is that plus `-check`.
- `disable-checkbox` disables the row's checkbox. `no-checkbox` leaves it out.

## Cells

```blade
<x-forms::table.cell name="status" />
<x-forms::table.cell :value="$user->created_at->diffForHumans()" />
<x-forms::table.cell>
    <x-forms::link-button :url="route('admin.users.edit', $user)" size="sm" color="light">{{ __('Edit') }}</x-forms::link-button>
</x-forms::table.cell>
```

A cell shows its slot, its `value`, or the row model's `name` attribute, formatted:

- A model with an `admin_link` accessor shows the link; a collection of them is joined with commas.
- A backed enum with `getColor()` shows a [status badge](./status.md); other backed enums show their label.
- `true`/`false` show "Yes"/"No"; arrays are joined with commas; empty values show "-".
- `multiline` keeps line breaks.

With a `name`, the cell gets `data-col="{label}"`, so a responsive stylesheet can show the column name on small screens. `:show-label="false"` leaves it out.

## Headings

```blade
<x-forms::table.heading label="ނަން" sortable="name" />
<x-forms::table.heading name="created_at" :label="__('Created')" />
<x-forms::table.heading :colspan="2">{{ __('Actions') }}</x-forms::table.heading>
```

`sortable` (or `name`, when `sortable` isn't given) is the column to sort by. The heading gets `data-sort-field` and the class `sorting`, or `sorting_asc` / `sorting_desc` when the request's `orderby` is this column (`order` gives the direction). The filter card carries `orderby` and `order` as hidden fields, and the table points at the filter form with `data-form-sortable` (`#filter`, or `filter-id`). Clicking a sortable heading (or pressing Enter or Space on it) sets those fields, toggling ascending and descending, and submits the filter form. The heading shows a sort icon (`icons.sort`, `sort_asc`, `sort_desc`) and gets `aria-sort`.

## Empty rows

Inside the `rows` slot, `<x-forms::table.empty-row>` shows a message across the table:

```blade
<x-slot:rows>
    @forelse ($users as $user)
        …
    @empty
        <x-forms::table.empty-row :columns="4">{{ __('No users match your search.') }}</x-forms::table.empty-row>
    @endforelse
</x-slot:rows>
```

Set `columns` to the number of columns including the checkbox column.

## Filter

`<x-forms::filter>` is a [card](./card.md) for filter fields, with hidden `orderby` and `order` fields. Put it in a `GET` form bound to the query string, so the fields keep their values:

```blade
<x-forms::form method="GET" :model="request()->query()" id="filter">
    <x-forms::filter :title="__('Filter')">
        <x-forms::select2 name="atoll" label="އަތޮޅު" :options="$atolls" />
        <x-forms::filter-submit :cancel-url="route('islands.index')" />
    </x-forms::filter>
</x-forms::form>
```

Attributes on `filter` go on the card.

## Filter buttons

`<x-forms::filter-submit>` renders a Filter submit button and a Clear link to `cancel-url`:

```blade
<x-forms::filter-submit :cancel-url="route('islands.index')" export />

<x-forms::filter-submit :cancel-url="route('islands.index')" :export="['xlsx' => 'Excel', 'csv' => 'CSV']" />
```

- `export` adds an Export submit button with `name="download"`. With `true` it sends `download=1`.
- With an array of `key => label`, the button sends the first key and a menu lists them all; each sends its key as `download`. Use keys: a plain string (`export="xlsx"`) becomes `[0 => 'xlsx']` and sends `download=0`. In `onu` the menu is a `<details>` closed by the package's script; in `bootstrap-6` it's a Bootstrap menu.
- Slots: `before` (before Filter), `after` (before Clear) and the default slot (after Clear).

## Per page

`<x-forms::per-page>` is a [Select2](./select2.md) named `per_page` with 10, 20, 50, 100 and 500:

```blade
<x-forms::per-page show-label />

<x-forms::per-page :amounts="[15 => 15, 30 => 30, 60 => 60]" :per-page="30" />
```

The selected amount is `per-page`, else the request's `per_page`, else `forms.defaults.per_page`, else the `per_page` setting (`javaabu/settings`), else 20. An amount that isn't in the list is added to it. The label is "Per page" (translated) and is hidden unless `show-label`. Other attributes go to the select.

## Search form

`<x-forms::search-form>` is a small `GET` form with one search field, without a label:

```blade
<x-forms::search-form route="admin.users.index" :placeholder="__('Search users…')" />

<x-forms::search-form :action="route('islands.index')" name="q" />
```

Give it `action`, or `route` and `params`. It's bound to the query string, so the field keeps the search.

## No items

`<x-forms::no-items>` shows an empty state with an icon, a title, a message and a Create New button:

```blade
<x-forms::no-items
    :create-action="route('admin.users.create')"
    :model="App\Models\User::class"
    model-type="users"
/>
```

- The button shows when `show-create` is true. When `show-create` isn't given, it shows if the signed-in user can `create` the `model` (a class name or a model).
- The message is "Let's create some new :model_type." with `model-type` (or "items"). `title` and `message` replace the texts.
- The slot replaces the button.

```blade
<x-forms::no-items icon="search" :title="__('No results')" :message="__('Try another search.')" :show-create="false" />
```

## Attributes

### `table`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `model` | `string` | `''` | Checkbox group name for select all. |
| `striped` | `bool` | `false` | Striped rows. |
| `table-class` | `string` | `''` | Classes on the `<table>`. |
| `filter-id` | `string` | `'filter'` | Id of the filter form, for sorting. |
| `no-checkbox` | `bool` | `false` | Leaves out the checkbox column. |
| `no-pagination` | `bool` | `false` | Leaves out the `pagination` slot. |
| `no-bulk` | `bool` | `false` | Leave out the bulk form even when the `bulk-form` slot is given. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slots: `headers`, `rows`, `bulk-form`, `pagination`, `before-table`, `before-headers`, `after-headers`, `tbody-open`, `after-tbody`.

### `table.row`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `model` | `mixed` | bound model | Model for the cells. |
| `name` | `string` | plural morph class | Checkbox group and checkbox name. |
| `model-id` | `string` | model key | Checkbox value. |
| `row-id` | `string` | `{name}-{model-id}-row` | Row `id`. |
| `no-checkbox` | `bool` | `false` | Leaves out the checkbox. |
| `disable-checkbox` | `bool` | `false` | Disables the checkbox. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `table.cell`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | `''` | Bound attribute to show. |
| `label` | `string` | from `name` | Column name for `data-col`. |
| `show-label` | `bool` | `true` | Adds `data-col`. |
| `value` | `mixed` | `null` | Value to show instead. |
| `model` | `mixed` | bound model | Model to read from. |
| `multiline` | `bool` | `false` | Keeps line breaks. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `table.heading`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `label` | `string` | `''` | Heading text. The slot replaces it. |
| `name` | `string` | `''` | Column, used as `sortable` when that's empty. |
| `sortable` | `string` | `name` | Column to sort by. |
| `colspan` | `int` | `1` | Columns to span. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `table.empty-row`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `columns` | `int` | `1` | Columns to span, including the checkbox column. |
| `no-checkbox` | `bool` | `false` | Set when the table has no checkbox column. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `bulk-actions`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `model` | `string` | required | Checkbox group name. |
| `actions` | `array` | required | `value => label` actions. Renders nothing when empty. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `filter`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the card. Slot: the filter fields.

### `filter-submit`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `cancel-url` | `string` | required | URL of the Clear link. |
| `export` | `bool`, `string` or `array` | `false` | Adds an Export button, or a menu of export types. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slots: `before`, `after`, default.

### `per-page`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `amounts` | `array` | `[10 => 10, 20 => 20, 50 => 50, 100 => 100, 500 => 500]` | Options. |
| `per-page` | `int` | request or config | Selected amount. |
| `label` | `string` | "Per page" | Label text. |
| `show-label` | `bool` | `false` | Shows the label. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `search-form`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | `'search'` | Field name. |
| `action` | `string` | `''` | Form action. |
| `route` | `string` | `''` | Route name for the action, when `action` is empty. |
| `params` | `array` | `[]` | Route parameters. |
| `placeholder` | `string` | "Search..." | Placeholder. |
| `method` | `string` | `'GET'` | Form method. |
| `model` | `mixed` | the query string | Values for the field. |
| `icon` | `string` | `icons.search` | Not rendered by the current views. |

### `no-items`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `create-action` | `string` | `'#'` | URL of the Create New button. |
| `model` | `string` or `object` | `null` | Class or model for the `create` permission check. |
| `model-type` | `string` | "items" | Plural name in the message. |
| `show-create` | `bool` | permission check | Shows the Create New button. |
| `title` | `string` | "It's a bit lonely here." | Title. |
| `message` | `string` | "Let's create some new :model_type." | Message. |
| `icon` | `string` | `icons.no_items` | Icon. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Slot: replaces the Create New button.

## React

```jsx
import { Table, TableRow, TableCell, TableHeading } from "@javaabu/forms"

<Table
  model="users"
  headers={<TableHeading label="ނަން" sortable="name" />}
  rows={users.map((user) => (
    <TableRow key={user.id} model={user} name="users">
      <TableCell name="name" />
    </TableRow>
  ))}
/>
```

Named slots are props of the same name. `bulk-actions`, `filter`, `filter-submit`, `per-page`, `search-form` and `no-items` have React components of the same names (`BulkActions`, `FilterSubmit`, …). `table.heading`'s `colspan` is Blade only (use plain HTML in React). See [Parity](../parity.md).
