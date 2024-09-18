---
title: Pagination blade partials
sidebar_position: 9
---

This package also provides blade partials for pagination views for Material Admin 2.6. You can use the partials like so in your blade views.

For `LengthAwarePaginator`

```bladehtml
{{ $users->links('forms::material-admin-26.pagination') }}
```

For `CursorPaginator`

```bladehtml
{{ $users->links('forms::material-admin-26.cursor-pagination') }}
```

Note that for `CursoPaginator`, you should import pagination sass styles from [`@javaabu/js-utilities`](https://github.com/Javaabu/js-utilities)

```sass
@import '@javaabu/js-utilities/src/scss/material-admin-26/pagination';
```
