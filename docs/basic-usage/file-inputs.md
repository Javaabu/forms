---
title: File and image inputs
sidebar_position: 9
---

# File and image inputs

`<x-forms::file>` and `<x-forms::image>` render a file picker that shows the current file, the name of a newly chosen file (or a preview for images), and a button to clear it. They read the current file from [`spatie/laravel-medialibrary`](https://spatie.be/docs/laravel-medialibrary), from a URL attribute, or from `default`. `file-upload` and `image-upload` upload the file as soon as it's chosen.

The script loads with the component (see [Assets](../advanced-usage/assets.md)). Forms with file inputs need [`files`](./forms.md#uploading-files).

## File input

```blade
<x-forms::form method="PATCH" :action="route('applications.update', $application)" :model="$application" files>
    <x-forms::file name="cv" label="ސީވީ" type="pdf" required />
</x-forms::form>
```

The field shows "No file selected." until a file is chosen. When the model has a file, it shows a link to download it.

## Allowed types and size

`type` is one or more file types from `Javaabu\Forms\Support\MimeTypes` (the same as javaabu/helpers' `AllowedMimeTypes`, which is used when installed): `image`, `icon`, `video`, `audio`, `excel`, `word`, `powerpoint`, `pdf`, `text`, `json`, `document` (the default) and `zip`. It sets the input's `accept` attribute and the hint below the field:

```blade
<x-forms::file name="attachment" :type="['pdf', 'word']" />
```

The hint reads "Only .pdf, .doc and .docx files of max … allowed.", with the size from `max-size`.

Override what `type` gives you with `mimetypes`, `extensions` (used in the hint) and `max-size` (in KB):

```blade
<x-forms::file name="data" mimetypes="text/csv" extensions="csv" :max-size="2048" />
```

:::note
Without `max-size`, the size limit (in KB) is read with `get_setting()` when [`javaabu/settings`](https://github.com/Javaabu/settings) is installed (`max_{type}_file_size`, then `max_image_file_size` or `max_upload_file_size`). Otherwise it's `forms.defaults.max_upload_file_size`, or 10240 KB.
:::

`:show-hint="false"` hides the hint. A `help` slot replaces it:

```blade
<x-forms::file name="cv">
    <x-slot:help>{{ __('Upload your CV as a PDF.') }}</x-slot:help>
</x-forms::file>
```

## Multiple files

`multiple` lets the user choose several files. The input's name gets `[]`:

```blade
<x-forms::file name="attachments" multiple />
```

```html
<input type="file" name="attachments[]" multiple …>
```

## Where the current file comes from

For the bound model (or `model`), in this order:

1. The model attribute with the field's name, if it isn't empty: a URL string or a `Media` object. An accessor works too.
2. The first media in the collection named `collection` (default: the field's name), when the model implements `Spatie\MediaLibrary\HasMedia`.
3. `default`: a URL or a `Media` object.

```blade
<x-forms::form :model="$article">
    {{-- $article->getMedia('featured_image')->first() --}}
    <x-forms::image name="featured_image" />

    {{-- media from another collection --}}
    <x-forms::file name="document" collection="attachments" />

    {{-- the "thumb" conversion's URL, or the original if it hasn't been generated --}}
    <x-forms::image name="photo" conversion="thumb" />
</x-forms::form>
```

`ignore-accessor` skips step 1. Use it when the model has an accessor with the field's name that returns a placeholder URL when there is no file.

```blade
<x-forms::image name="avatar" ignore-accessor />
```

## Image input

`<x-forms::image>` shows a preview box. Clicking it opens the file picker, and a chosen image shows in it straight away.

```blade
<x-forms::image name="featured_image" label="ފޮޓޯ" :width="1200" :height="630" cover />
```

- `width` and `height` are the recommended size in pixels (default `400` × `400`). They set the preview's aspect ratio and the hint ("Recommended 1200px x 630px.").
- `aspect-ratio` sets the ratio directly, as height ÷ width (`0.5625` for 16:9). `:maintain-aspect-ratio="false"` makes the preview square.
- `cover` makes the image fill the preview.
- `fullwidth` makes the preview as wide as the field.
- `circle` shows a round preview, for profile photos. It forces a 1:1 ratio.
- `icon` is the icon shown in an empty preview (`icons.image`).

```blade
<x-forms::image name="avatar" circle cover :width="300" :height="300" />
```

## Uploading straight away

`<x-forms::file-upload>` and `<x-forms::image-upload>` (or `upload` on `file` or `image`) send the file as soon as it's chosen, without submitting the form:

```blade
<x-forms::form method="PATCH" :action="route('profile.update')" :model="$user" files>
    <x-forms::image-upload name="avatar" circle cover />
</x-forms::form>
```

- The file is checked against `max-size` and the accepted types first.
- It's posted to the form's `action` with the form's method (`_method` for `PATCH`/`PUT`), with only that field. Then the page reloads.
- The remove button asks for confirmation, then posts the field with an empty value.

So the endpoint has to accept a request with only the file field, and treat an empty value as "remove the file":

```php
public function update(UpdateProfileRequest $request): RedirectResponse
{
    $user = $request->user();

    if ($request->has('avatar')) {
        $request->hasFile('avatar')
            ? $user->addMediaFromRequest('avatar')->toMediaCollection('avatar')
            : $user->clearMediaCollection('avatar');
    }

    // ...

    return back();
}
```

Upload fields must be inside a form.

## Disabled

`disabled` disables the input and its buttons. The current file still shows and can be downloaded.

## Attributes

### `file`

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | Field name. |
| `label` | `string` | from `name` | Label text. |
| `type` | `string` or `array` | `'document'` | Allowed file type(s) from `MimeTypes` (see [upgrading](../upgrading.md#file-types-without-javaabuhelpers) to register more). |
| `mimetypes` | `string` or `array` | from `type` | Accepted MIME types (the `accept` attribute). |
| `extensions` | `string` or `array` | from `mimetypes` | Extensions shown in the hint. |
| `max-size` | `int` | from `type` | Maximum size in KB, shown in the hint and checked before uploading. |
| `collection` | `string` | `name` | Media library collection. |
| `conversion` | `string` | `''` | Media library conversion for the file URL. |
| `model` | `mixed` | bound model | Model to read the file from. `false` turns binding off. |
| `default` | `string` or `Media` | `null` | File URL or media when the model has none. |
| `ignore-accessor` | `bool` | `false` | Reads only the media collection, not the attribute. |
| `multiple` | `bool` | `false` | Lets the user choose several files; adds `[]` to the name. |
| `upload` | `bool` | `false` | Uploads the file as soon as it's chosen. |
| `show-hint` | `bool` | `true` | Shows the allowed types and size. |
| `required` | `bool` | `false` | Adds `required` and the required marker. |
| `disabled` | `bool` | `false` | Disables the input and its buttons. |
| `file-input-class` | `string` | `''` | Classes on the file input wrapper. |
| `clear-icon` | `string` | `icons.clear` | Icon of the remove button. |
| `download-icon` | `string` | `icons.download` | Icon before the current file's name. |
| `upload-icon` | `string` | `icons.upload` | Icon of the upload button. |
| `show-label` | `bool` | `true` | `false` removes the label and field wrapper. |
| `show-errors` | `bool` | `true` | Shows errors. |
| `inline` | `bool` | `false` | Label beside the input. |
| `inline-label-class` | `string` | config | Classes for the label column. |
| `inline-input-class` | `string` | config | Classes for the control column. |
| `form-group-class` | `string` | `''` | Classes on the field wrapper. |
| `show-js-errors` | `bool` | `false` | Adds an empty error list for JavaScript validation. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

`file-upload` takes the same attributes except `upload` (always on) and `multiple`.

Slot: `help` (replaces the hint).

### `image`

The attributes of `file` except `clear-icon`, `download-icon` and `multiple`; `type` defaults to `'image'`. And:

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `width` | `int` | `400` | Recommended width in pixels. |
| `height` | `int` | `400` | Recommended height in pixels. |
| `aspect-ratio` | `float` | `height / width` | Preview ratio, as height ÷ width. |
| `maintain-aspect-ratio` | `bool` | `true` | `false` makes the preview square. |
| `cover` | `bool` | `false` | Image fills the preview. |
| `fullwidth` | `bool` | `false` | Preview as wide as the field. |
| `circle` | `bool` | `false` | Round preview with a 1:1 ratio. |
| `icon` | `string` | `icons.image` | Icon in an empty preview. |

`image-upload` takes the same attributes except `upload` (always on).

## React

```jsx
import { File, Image, ImageUpload } from "@javaabu/forms"

<File name="cv" label="ސީވީ" type="pdf" required />
<File name="attachments" multiple />
<Image name="featured_image" width={1200} height={630} cover />
<ImageUpload name="avatar" circle cover />
```

React's `File` also has an `onUploaded` callback. See [Parity](../parity.md).
