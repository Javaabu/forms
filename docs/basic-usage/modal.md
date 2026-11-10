---
title: Modal
sidebar_position: 19
---

# Modal

`<x-forms::modal>` renders a dialog as a native `<dialog>` element, with a title, an optional description, a body and an optional footer.

```blade
<x-forms::modal id="delete-article" title="ފޮހެލަން ބޭނުންތަ؟" :description="__('This cannot be undone.')" size="sm">
    <p>{{ $article->title }}</p>

    <x-slot:footer>
        <x-forms::form method="DELETE" :action="route('articles.destroy', $article)">
            <x-forms::submit color="danger">ފޮހެލާ</x-forms::submit>
        </x-forms::form>
    </x-slot:footer>
</x-forms::modal>
```

Give every modal an `id`; you open it by its id. Without one it gets a random id.

## Opening and closing

The two frameworks use different attributes:

`onu`, with the package's script (see [Assets](../advanced-usage/assets.md)):

```blade
<x-forms::button type="button" color="danger" data-modal-target="#delete-article">ފޮހެލާ</x-forms::button>

{{-- or --}}
<x-forms::button type="button" data-forms-toggle="modal" data-target="#delete-article">ފޮހެލާ</x-forms::button>
```

It closes with its close button, any element with `data-dismiss="modal"` inside it, a click on the backdrop, or Escape. The dialog has `data-state="open"` or `data-state="closed"` for styling.

`bootstrap-6`, with Bootstrap's JavaScript:

```blade
<x-forms::button type="button" data-bs-toggle="dialog" data-bs-target="#delete-article">ފޮހެލާ</x-forms::button>
```

It closes with any element with `data-bs-dismiss="dialog"`.

In either framework you can also use the browser's API: `document.getElementById('delete-article').showModal()` and `.close()`.

## Sizes

| `size` | `onu` | `bootstrap-6` |
| --- | --- | --- |
| `sm` | small | `dialog-sm` |
| `md`, `default` | medium | default size |
| `lg` (default) | large | `dialog-lg` |
| `xl` | extra large | `dialog-xl` |
| `fullscreen`, `full` | full screen | `dialog-fullscreen` |

The v1 `modal-size-class` still works: `modal-size-class="modal-xl"` is `size="xl"`.

## Title and close button

With a `title`, the dialog gets `aria-labelledby` pointing at the title (`{id}-title`). `description` adds a line of text under the title, and needs a `title`.

In `onu` the close button is always there. In `bootstrap-6` it's in the header, so a modal without a `title` has no close button; add your own with `data-bs-dismiss="dialog"`.

## Forms in a modal

Put the form in the body, or wrap the body and footer with it so the footer's submit button belongs to it:

```blade
<x-forms::modal id="add-island" title="ރަށެއް އިތުރުކުރޭ">
    <x-forms::form :action="route('islands.store')" id="add-island-form">
        <x-forms::text name="name" label="ނަން" thaana required />
        <x-forms::select2 name="atoll" label="އަތޮޅު" :options="$atolls" parent-modal="#add-island" />
    </x-forms::form>

    <x-slot:footer>
        <x-forms::button type="button" color="light" data-dismiss="modal">ބާތިލްކުރޭ</x-forms::button>
        <x-forms::submit form="add-island-form">ސޭވްކުރޭ</x-forms::submit>
    </x-slot:footer>
</x-forms::modal>
```

To reopen the modal after a failed validation, open it from your own script when `$errors` has messages for its fields. Date pickers inside a modal open inside it.

## Rendered HTML

```html
<!-- onu (classes shortened) -->
<dialog class="forms-dialog …" id="delete-article" data-slot="dialog-content" aria-labelledby="delete-article-title">
    <div class="…" data-slot="modal-header">
        <h2 class="…" id="delete-article-title" data-slot="modal-title">ފޮހެލަން ބޭނުންތަ؟</h2>
        <p class="text-sm text-muted-foreground" data-slot="modal-description">This cannot be undone.</p>
    </div>
    <button type="button" class="… absolute top-3 end-3" data-dismiss="modal" aria-label="Close">…</button>
    <div class="…" data-slot="modal-body">…</div>
    <div class="…" data-slot="modal-footer">…</div>
</dialog>

<!-- bootstrap-6 -->
<dialog class="dialog dialog-sm" id="delete-article" aria-labelledby="delete-article-title">
    <div class="dialog-header">
        <h2 class="dialog-title" id="delete-article-title">ފޮހެލަން ބޭނުންތަ؟</h2>
        <p class="dialog-description fg-3 mb-0">This cannot be undone.</p>
        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Close"></button>
    </div>
    <div class="dialog-body">…</div>
    <div class="dialog-footer">…</div>
</dialog>
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `id` | `string` | random | Dialog id, used to open it. |
| `title` | `string` | `''` | Heading. |
| `description` | `string` | `''` | Text under the title. |
| `size` | `string` | `'lg'` | See [Sizes](#sizes). |
| `modal-size-class` | `string` | `null` | v1 size class (`modal-sm`, `modal-xl`, …). Replaces `size`. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the `<dialog>`. Slots: default (the body), `footer`.

## React

```jsx
import { Modal } from "@javaabu/forms"

<Modal id="delete-article" title="ފޮހެލަން ބޭނުންތަ؟" description="This cannot be undone." size="sm" footer={<Submit color="danger">ފޮހެލާ</Submit>}>
  …
</Modal>
```

React opens modals with state (`open`, `defaultOpen`, `onOpenChange`, `trigger`). See [Parity](../parity.md).
