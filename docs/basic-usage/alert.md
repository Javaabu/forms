---
title: Alert
sidebar_position: 12
---

The `alert` component displays messages using the selected CSS framework's alert styles. It supports Bootstrap 5 and Material Admin 2.6, with optional headings, icons, and a dismiss button.

## Basic Usage

Place the message in the default slot. No attributes are required.

```html
<x-forms::alert>
    Your application is being reviewed.
</x-forms::alert>
```

By default, the component renders a `div` with the classes `alert alert-primary` and `role="alert"`.

## Alert Types

Use `type` to choose the alert style. Its value is appended to `alert-`, so `type="success"` produces the `alert-success` class. Choose a type supported by your application's CSS framework.

```html
<x-forms::alert type="success">
    Your changes have been saved.
</x-forms::alert>

<x-forms::alert type="warning">
    Your subscription expires soon.
</x-forms::alert>

<x-forms::alert type="danger">
    The upload failed. Please try again.
</x-forms::alert>
```

## Headings and Content

Pass `heading` to display an `h4` with the `alert-heading` class above the message. The default slot can contain HTML, including paragraphs and links.

```html
<x-forms::alert type="success" heading="Application submitted">
    <p>We have received your application.</p>
    <a href="/applications" class="alert-link">View your applications</a>
</x-forms::alert>
```

Use Blade's `:` syntax for dynamic or translated headings:

```html
<x-forms::alert type="warning" :heading="__('Action required')">
    {{ __('Please complete your profile before applying.') }}
</x-forms::alert>
```

## Icons

Pass the complete CSS classes for an icon using `icon`. The component places the icon beside the heading and content and marks it with `aria-hidden="true"`.

```html
<x-forms::alert type="info" icon="fa-solid fa-circle-info" heading="Before you begin">
    Have your supporting documents ready.
</x-forms::alert>
```

Load the corresponding icon library in your application. The component uses the classes you supply directly; it does not prepend the framework's configured icon prefix.

## Dismissible Alerts

Add `dismissible` to display a close button and apply the `alert-dismissible fade show` classes.

```html
<x-forms::alert type="success" dismissible>
    Your preferences have been updated.
</x-forms::alert>
```

Dismissal requires the Bootstrap alert JavaScript used by your theme to be loaded in your application. The component renders the button and its attributes; it does not load JavaScript itself.

| Framework | Close button class | Dismiss attribute |
| --- | --- | --- |
| `bootstrap-5` | `btn-close` | `data-bs-dismiss="alert"` |
| `material-admin-26` | `close` | `data-dismiss="alert"` |

You can also bind the option to a boolean with `:dismissible="true"` or `:dismissible="false"`.

### Flash Messages

Render an alert conditionally to show a session message:

```html
@if (session('status'))
    <x-forms::alert type="success" dismissible>
        {{ session('status') }}
    </x-forms::alert>
@endif
```

## Additional HTML Attributes

Additional attributes are applied to the outer alert `div`. Custom classes are merged with the component's alert classes.

```html
<x-forms::alert type="info" id="application-notice" class="mb-4" data-notice="application">
    Applications close at the end of the month.
</x-forms::alert>
```

## Available Options

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `type` | `string` | `'primary'` | Alert style, used to generate the `alert-{type}` class. |
| `dismissible` | `bool` | `false` | Adds a close button and the dismissal and transition classes. Requires your theme's alert JavaScript. |
| `icon` | `string` | `''` | Complete icon CSS classes. An empty string omits the icon. |
| `heading` | `string` | `''` | Heading displayed above the slot content. An empty string omits the heading. |
| `framework` | `string` | `''` | Uses `forms.framework` when omitted. Supports `bootstrap-5` and `material-admin-26`. |

To select a framework for a single alert, pass `framework` explicitly:

```html
<x-forms::alert type="info" framework="material-admin-26" icon="zmdi zmdi-info-outline">
    Please review the instructions before continuing.
</x-forms::alert>
```

See [Installation & Setup](../installation-and-setup.md) to configure the default framework or publish the component views.
