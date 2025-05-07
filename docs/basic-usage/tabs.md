---
title: Tabs
sidebar_position: 5
---

You can use the `tabs` component to render JavaScript tabs. The `tabs` component requires an array or Collection of tabs. Optionally you can pass also pass in the name of the tab to be active. By default, the first tab will be marked as active. The content for each tab can be passed as named slots with the slot names same as the name of the tab in kebab case.

```php
$items = [
    [
        'name' => 'home'
    ],
    [
        'name'     => 'profile',
        'title'    => __('Profile'),
    ],  
    [
        'name'     => 'contact',        
        'disabled' => true,
    ],
    [
        'name'     => 'external-tab',
        'url'      => 'http://example.com',
    ],
];
```

```html
<x-forms::tabs :tabs="$items" active="profile">
    <x-slot:home>
        ...
    </x-slot:home>

    <x-slot:profile>
        ...
    </x-slot:profile>

    <x-slot:contact>
        ...
    </x-slot:contact>
</x-forms::tabs>
```

The tab items support the following values:
- `'name'` - (Required) The name of the tab. Preferrably, in kebab case. Will be used as the id of the tab pane.
- `'title'` - The title of the tab use in the tab link. If not provided, the title will be generated using the `name`.
- `'disabled'` - Whether the tab should be disabled.
- `'url''` - If you want to link to an actual url instead of a tab.

# NavTabs
The `NavTabs` component renders a set of tabs that behave as navigation links. Unlike traditional tab components, these tabs do not control a tab pane or content area—they simply act as navigational links to different routes or pages.

## Usage Example
In your Blade view, define the $tabs array with the required configuration for each tab:
```php
   $tabs = [
        [
            'title' => __('User Details'),
            'active' => request()->is('admin.users.*'),
            'disabled' => false,
            'icon' => 'zmdi zmdi-account',
            'url' => route('admin.users.edit', $user->id),
        ],
        [
            'title' => __('User Permissions'),
            'active' => request()->is('admin.users.permissions.*'),
            'disabled' => ! isset($user), // if user is not set, disable the tab
            'icon' => 'zmdi zmdi-shield-security',
            'url' => route('admin.users.permissions.index', $user->id),
        ],
    ];
```
Then, render the `NavTabs` component in your Blade template:
```html
<div class="card pb-0"> <!-- Optional wrapper -->
    <x-forms::nav-tabs :tabs="$tabs" />
</div>
```

## Tab Configuration
Each item in the `$tabs` array supports the following keys:

| Key        | Required | Description                                                                                                                |
| ---------- | -------- | -------------------------------------------------------------------------------------------------------------------------- |
| `title`    | Yes      | The label displayed on the tab.                                                                                            |
| `active`   | No       | A boolean value that determines whether the tab is currently active (highlighted). Defaults to `false`.                    |
| `disabled` | No       | A boolean value that disables the tab (renders it inactive and non-clickable). Defaults to `false`.                        |
| `icon`     | No       | A string representing the icon class (e.g., from ZMDI or Font Awesome) to display alongside the title. Defaults to `null`. |
| `url`      | No       | The URL the tab links to. If not provided, defaults to `'#'`.                                                              |

> This component is ideal for creating top-level navigation within a card layout, especially in admin or settings interfaces.
