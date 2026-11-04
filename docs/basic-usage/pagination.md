---
title: Pagination
sidebar_position: 23
---

# Pagination

`<x-forms::pagination>` renders a paginator's links with a "Showing 10 from total 30 entries" summary, in the framework's style.

```blade
<x-forms::pagination :paginator="$users" />
```

Pass any paginator. With `paginate()` it also shows the total; `simplePaginate()` shows the previous and next links only.

```php
$users = User::query()->latest()->paginate(20)->withQueryString();
```

`withQueryString()` keeps filters and the search in the page links.

## The paginator views

The component renders `$paginator->links()` with the package's views. Use them directly where you already call `links()`:

```blade
{{ $users->links('forms::onu.pagination') }}

{{ $users->links('forms::bootstrap-6.pagination') }}
```

To use them for every paginator in your app, set the default view in a service provider:

```php
use Illuminate\Pagination\Paginator;

public function boot(): void
{
    Paginator::defaultView('forms::' . config('forms.framework') . '.pagination');
}
```

The v1 views `forms::material-admin-26.pagination` and `forms::material-admin-26.cursor-pagination` were removed with the Material Admin framework. There is no cursor pagination view in v2.

## Text and direction

The summary, "Previous", "Next" and the navigation's `aria-label` come from `lang/{en,dv}/strings.php` (`pagination_showing`, `previous`, `next`, `pagination`), so they're in Dhivehi on Dhivehi pages: "ޖުމްލަ 30 އިން 10 ދައްކަނީ". In `onu` the arrows turn around in right-to-left pages.

## Rendered HTML

```html
<!-- onu (classes shortened) -->
<div class="flex items-center justify-between">
    <div class="text-sm text-muted-foreground">Showing 10 from total 30 entries</div>
</div>
<nav class="…" data-slot="pagination" role="navigation" aria-label="Pagination">
    <ul class="pagination …" data-slot="pagination-content">
        <li class="page-item" data-slot="pagination-item">
            <a class="page-link …" data-slot="pagination-link" href="/users?page=1" rel="prev" aria-label="Previous">…</a>
        </li>
        <li class="page-item active" data-slot="pagination-item">
            <a class="page-link …" data-slot="pagination-link" data-active="true" aria-current="page" href="/users?page=2">2</a>
        </li>
        …
    </ul>
</nav>

<!-- bootstrap-6 -->
<div class="d-flex justify-content-between align-items-center">
    <div class="fg-3">Showing 10 from total 30 entries</div>
</div>
<nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="/users?page=1" rel="prev" aria-label="Previous">&lsaquo;</a></li>
        …
    </ul>
</nav>
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `paginator` | `LengthAwarePaginator` | required | The paginator to render. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

## React

```jsx
import { Pagination } from "@javaabu/forms"

<Pagination paginator={users} />
```

See [Parity](../parity.md).
