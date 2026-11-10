---
title: Buttons
sidebar_position: 14
---

# Buttons

`<x-forms::button>`, `<x-forms::submit>`, `<x-forms::link-button>` and `<x-forms::button-group>` render buttons and links styled as buttons, with colours, sizes, icons and a loading spinner.

## Buttons

```blade
<x-forms::button type="button" color="secondary">{{ __('Preview') }}</x-forms::button>
```

Set `type` on every `<x-forms::button>` that isn't meant to submit. As in v1, a button without `type` gets no `type` attribute, so inside a form it submits it.

## Submit buttons

`<x-forms::submit>` is a `type="submit"` button that shows a spinner when its form is submitted and is then disabled, so it can't be pressed twice:

```blade
<x-forms::submit>{{ __('Save') }}</x-forms::submit>

<x-forms::submit color="danger" start-icon="trash-2">ފޮހެލާ</x-forms::submit>
```

The spinner is in the button from the start, with `hidden`, and the package's script shows it on submit. If another script cancels the submit, nothing changes. Turn it off with `:animate="false"`. Any button can have it with `animate`:

```blade
<x-forms::button type="submit" name="action" value="publish" animate>{{ __('Publish') }}</x-forms::button>
```

## Showing a loading state

`loading` shows the spinner straight away and marks the button busy (`aria-busy="true"`, `aria-disabled="true"`, `data-loading="true"`):

```blade
<x-forms::button type="button" :loading="$is_exporting">{{ __('Export') }}</x-forms::button>
```

## Links that look like buttons

```blade
<x-forms::link-button :url="route('articles.create')" start-icon="plus">
    {{ __('New article') }}
</x-forms::link-button>

<x-forms::link-button :url="route('articles.index')" color="light">ބާތިލްކުރޭ</x-forms::link-button>
```

`disabled` removes the `href` and adds `aria-disabled="true"` and `role="link"`, so the link can't be followed.

## Colours

`color` takes these names in both frameworks:

| `color` | `onu` variant | `bootstrap-6` classes |
| --- | --- | --- |
| `primary` (default) | `default` | `btn-solid theme-primary` |
| `secondary` | `secondary` | `btn-solid theme-secondary` |
| `success` | `success` | `btn-solid theme-success` |
| `danger` | `destructive` | `btn-solid theme-danger` |
| `warning` | `warning` | `btn-solid theme-warning` |
| `info` | `default` | `btn-solid theme-info` |
| `light` | `outline` | `btn-subtle theme-secondary` |
| `dark` | `secondary` | `btn-solid theme-inverse` |
| `link` | `link` | `btn-link` |
| `outline-{color}` | `outline` | `btn-outline theme-{color}` |

`bootstrap-6` also takes `accent` and `inverse`. In `onu`, an unknown name falls back to the `default` variant. To change the mapping, see [Custom frameworks](../advanced-usage/custom-frameworks.md#changing-a-bundled-frameworks-colours).

## Sizes

| `size` | `onu` | `bootstrap-6` |
| --- | --- | --- |
| `''`, `md`, `default` | default size | default size |
| `xs` | extra small | `btn-xs` |
| `sm` | small | `btn-sm` |
| `lg` | large | `btn-lg` |
| `icon` | square, for an icon only | `btn-icon` |
| `icon-xs`, `icon-sm`, `icon-lg` | square, in that size | `btn-icon-xs`, … |

Use `sm`, `lg` and `icon` when a page has to work in both frameworks.

```blade
<x-forms::button type="button" size="icon" color="light" aria-label="{{ __('Edit') }}">
    <x-forms::icon name="pencil" />
</x-forms::button>
```

## Icons

`start-icon` and `end-icon` add an icon before or after the text. Use a [bundled Lucide name, a logical name or icon font classes](./icons.md):

```blade
<x-forms::link-button :url="$next_url" end-icon="chevron-right">ކުރިއަށް</x-forms::link-button>
```

In right-to-left pages, `start` is on the right. Flip direction icons yourself with `class="rtl:rotate-180"` on an `<x-forms::icon>` in the slot if needed.

## Button groups

`<x-forms::button-group>` joins buttons together. It's horizontal by default; `:inline="false"` stacks them:

```blade
<x-forms::button-group>
    <x-forms::button type="button" color="light">{{ __('Day') }}</x-forms::button>
    <x-forms::button type="button" color="light">{{ __('Week') }}</x-forms::button>
    <x-forms::button type="button" color="light">{{ __('Month') }}</x-forms::button>
</x-forms::button-group>
```

## Rendered HTML

`<x-forms::submit start-icon="check">Save</x-forms::submit>`, with classes shortened to `…`:

```html
<!-- onu -->
<button class="… animate-submit" data-slot="button" data-variant="default" data-size="default" type="submit">
    <svg class="forms-icon forms-spinner animate-spin" hidden data-slot="button-spinner" data-icon-name="loader-circle" …></svg>
    <svg class="forms-icon" data-icon="inline-start" data-icon-name="check" …></svg>
    Save
</button>

<!-- bootstrap-6 -->
<button class="btn-solid theme-primary animate-submit" type="submit">
    <svg class="forms-icon forms-spinner animate-spin" hidden data-slot="button-spinner" …></svg>
    <svg class="forms-icon" data-icon="inline-start" data-icon-name="check" …></svg>
    Save
</button>
```

A button group is `div[data-slot="button-group"][role="group"]` in `onu`, and `div.btn-group` (or `.btn-group-vertical`) in `bootstrap-6`.

## Attributes

### `button`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `type` | `string` | `''` | `button`, `submit` or `reset`. Empty renders no `type` (the browser treats it as `submit`). |
| `color` | `string` | `'primary'` | See [Colours](#colours). |
| `size` | `string` | `''` | See [Sizes](#sizes). |
| `start-icon` | `string` | `''` | Icon before the text. |
| `end-icon` | `string` | `''` | Icon after the text. |
| `animate` | `bool` | `false` | Shows a spinner and disables the button when its form submits. |
| `loading` | `bool` | `false` | Shows the spinner and marks the button busy. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes (`name`, `value`, `disabled`, `class`, `data-*`) go on the `<button>`. Slot: the content.

### `submit`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `color` | `string` | `'primary'` | See [Colours](#colours). |
| `size` | `string` | `''` | See [Sizes](#sizes). |
| `start-icon` | `string` | `''` | Icon before the text. |
| `end-icon` | `string` | `''` | Icon after the text. |
| `animate` | `bool` | `true` | Shows a spinner and disables the button when its form submits. |
| `loading` | `bool` | `false` | Shows the spinner and marks the button busy. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `link-button`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `url` | `string` | `''` | The `href`. |
| `color` | `string` | `'primary'` | See [Colours](#colours). |
| `size` | `string` | `''` | See [Sizes](#sizes). |
| `start-icon` | `string` | `''` | Icon before the text. |
| `end-icon` | `string` | `''` | Icon after the text. |
| `disabled` | `bool` | `false` | Removes the `href` and marks the link disabled. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

### `button-group`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `inline` | `bool` | `true` | Horizontal group. `false` stacks the buttons. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

## React

```jsx
import { Button, Submit, LinkButton, ButtonGroup } from "@javaabu/forms"

<Submit startIcon="check">Save</Submit>
<Button type="button" color="secondary" size="sm" loading={isExporting}>Export</Button>
<LinkButton url="/articles/create" startIcon="plus">New article</LinkButton>
<ButtonGroup>…</ButtonGroup>
```

See [Parity](../parity.md).
