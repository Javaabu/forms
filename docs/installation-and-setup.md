---
title: Installation & Setup
sidebar_position: 1.2
---

# Installation and setup

## 1. Install

```bash
composer require javaabu/forms
```

The service provider registers itself. This also installs [javaabu/manifest](https://github.com/Javaabu/manifest), which loads the components' JavaScript and CSS.

:::note Before the v2 release

v2 is developed on the `next-gen` branch and depends on unreleased Javaabu packages. Until it's tagged, require it from GitHub:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/Javaabu/forms" },
        { "type": "vcs", "url": "https://github.com/Javaabu/manifest" }
    ],
    "require": {
        "javaabu/forms": "^2.0@dev"
    }
}
```

:::

## 2. Choose a framework

`onu` is the default. To use Bootstrap 6 instead, set it in `.env` (or publish the config):

```dotenv
FORMS_FRAMEWORK=bootstrap-6
```

## 3. Add the styles

### Onu with Tailwind CSS (recommended)

```bash
npm install @javaabu/onu tailwindcss @tailwindcss/vite
```

```css
/* resources/css/app.css */
@import "tailwindcss";
@import "@javaabu/onu/tailwind.css";
@import "../../vendor/javaabu/forms/resources/css/onu.css";
```

Your build now contains the classes the components use. Turn off the prebuilt stylesheet so Onu's CSS isn't loaded twice:

```dotenv
FORMS_STYLES=false
```

### Onu without Tailwind

Do nothing: when `FORMS_STYLES` is on (the default), pages that use the components get the prebuilt Onu stylesheet (Tailwind, Onu and the forms styles, the `forms::onu` asset) through javaabu/manifest.

### Bootstrap 6

Load Bootstrap 6's CSS and JavaScript as you normally would. The components use Bootstrap's own `data-bs-*` attributes for dialogs, menus, tabs and alerts. See [Bootstrap 6](./frameworks/bootstrap-6.md).

## 4. Scripts and styles

The components ask javaabu/manifest for the assets they use (the core behaviours, Tom Select for `select2`, flatpickr for dates, file inputs, TinyMCE setup), and manifest puts the tags in the page: styles before `</head>`, scripts before `</body>`, once each. Your layout only needs a `<head>` and a `<body>`.

To place them yourself, use manifest's directives:

```blade
<head>
    @manifestStyles
</head>
<body>
    ...
    @manifestScripts
</body>
```

If your app builds with Vite, add manifest's Vite plugin so the package's sources build with your app (otherwise the prebuilt files are used):

```js
// vite.config.js
import laravel from "laravel-vite-plugin"
import manifest from "./vendor/javaabu/manifest/dist/vite.js"

export default defineConfig({
  plugins: [laravel({ input: ["resources/css/app.css", "resources/js/app.js"] }), manifest()],
})
```

With the plugin, install the npm packages the sources import; `php artisan manifest:check` lists them (see [npm packages](./requirements.md#npm-packages)). See [Assets](./advanced-usage/assets.md) for the asset names, the Vite setup and turning assets off.

Some components still need a script that takes your settings, and these are pushed to the `scripts` stack: Google Maps for `map-input` (with `MAP_API_KEY`) and TinyMCE for `wysiwyg`. Render the stack in your layout:

```blade
    @stack('scripts')
</body>
```

## 5. Optional: publish files

```bash
# Config: config/forms.php
php artisan vendor:publish --tag=forms-config

# Translations: lang/vendor/forms/{en,dv}/strings.php
php artisan vendor:publish --tag=forms-translations

# Every view: resources/views/vendor/forms
php artisan vendor:publish --tag=forms-views

# One view, picked from a list
php artisan forms:publish-view

# Prebuilt CSS and JS, served as static files from public/
php artisan vendor:publish --tag=manifest-dist
```

Every config option is described in [Configuration](./advanced-usage/configuration.md).

## Your first form

```blade
<x-forms::form :action="route('contacts.store')">
    <x-forms::text name="name" label="ނަން" required />
    <x-forms::email name="email" required />
    <x-forms::textarea name="message" thaana />

    <x-forms::submit>{{ __('Send') }}</x-forms::submit>
</x-forms::form>
```

After a failed validation, the fields keep what was typed and show their errors. Continue with [Forms](./basic-usage/forms.md) and [Model binding](./basic-usage/model-binding.md).
