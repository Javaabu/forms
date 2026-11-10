---
title: Assets (JavaScript and CSS)
sidebar_position: 2
---

# Assets

The components' JavaScript and CSS ship inside the Composer package and are loaded through [javaabu/manifest](https://github.com/Javaabu/manifest). A component tells manifest which assets it needs while it renders, and manifest adds the tags to the page once each: styles before `</head>`, scripts before `</body>`. Pages that don't use a component don't load its script.

## The assets

| Asset | Loaded by | What it does |
| --- | --- | --- |
| `forms::forms` | every component | Conditional sections (`conditional-wrapper`), select all (`table`), the submit spinner, focus on the first error, the date clear button, Thaana typing (`thaana`), `auto-resize`, `decimals`, and the Onu dialog, tab, menu and alert widgets |
| `forms::select` (+ `forms::select-styles`) | `select2`, `bulk-actions`, `per-page` | Searchable, ajax, tag and dependent selects with [Tom Select](https://tom-select.js.org) |
| `forms::dates` (+ `forms::dates-styles`) | `date`, `datetime`, `time` | Date and time pickers with [flatpickr](https://flatpickr.js.org), in English or Dhivehi |
| `forms::files` | `file`, `file-upload`, `image`, `image-upload` | File names, image previews, clearing and uploads |
| `forms::wysiwyg` | `wysiwyg`, `textarea wysiwyg` | Starts TinyMCE (loaded by your app) on the textarea |
| `forms::onu` | `onu` components, when `forms.assets.styles` is on | The prebuilt stylesheet: Tailwind, Onu and the forms styles |

Run `php artisan manifest:list` to see them with their files and dependencies.

## Placing the tags yourself

```blade
<head>
    @manifestStyles
</head>
<body>
    {{ $slot }}

    @manifestScripts
</body>
```

Anything a directive prints isn't injected again. `@manifestScripts('forms')` prints only this package's scripts.

## Requiring an asset without a component

Markup you write yourself with the same `data-` attributes needs the script on the page:

```blade
@php(\Javaabu\Manifest\Facades\Manifest::require('forms::select'))
```

## Building with your app's Vite

With manifest's Vite plugin, the package's TypeScript sources build with your app, so the libraries are shared and your Vite config applies:

```js
// vite.config.js
import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import tailwindcss from "@tailwindcss/vite"
import manifest from "./vendor/javaabu/manifest/dist/vite.js"

export default defineConfig({
  plugins: [laravel({ input: ["resources/css/app.css", "resources/js/app.js"] }), tailwindcss(), manifest()],
})
```

Install the packages the sources import (`php artisan manifest:check` lists what's missing):

```bash
npm install tom-select flatpickr @javaabu/onu tailwindcss react
```

`react` is needed only to resolve `@javaabu/onu/thaana` while building; no React code is bundled, and a Blade app doesn't need `react-dom`, Inertia or the React `@javaabu/forms`. See [npm packages](../requirements.md#npm-packages).

The sources are importable too, under `@javaabu/forms-blade` (not `@javaabu/forms`, which is the React package):

```js
import { init } from "@javaabu/forms-blade/select"

init(document.querySelector("#my-modal"))
```

Without the plugin, manifest serves the prebuilt files from the package's `dist/`. Publish them to `public/` to serve them as static files:

```bash
php artisan vendor:publish --tag=manifest-dist
```

## Turning assets off

```dotenv
# Load nothing; include your own scripts and styles
FORMS_ASSETS=false

# Keep the scripts, but not the prebuilt Onu stylesheet (your Tailwind build imports resources/css/onu.css)
FORMS_STYLES=false
```

## Third-party scripts

Two components need a script that takes your settings, which they push to the `scripts` stack (`forms.scripts_stack`) once per page:

- `map-input`: the Google Maps loader, with `forms.map_api_key` (`MAP_API_KEY`).
- `wysiwyg`: TinyMCE, from `forms.wysiwyg.tinymce_url` (default `asset('vendors/tinymce/tinymce.min.js')`). TinyMCE isn't bundled because of its size and licence; host it in your app.

```blade
    @stack('scripts')
</body>
```

## Content added later

The scripts enhance elements added after the page loads (for example a form loaded into a modal) by themselves. To do it right away, call `init(element)` from the asset's module.
