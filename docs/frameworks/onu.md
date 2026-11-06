---
title: Onu
sidebar_position: 1
---

# Onu

`onu` is the default framework. The components output the same markup, `data-slot` attributes and Tailwind classes as the React components in [`@javaabu/onu`](https://github.com/Javaabu/onu), so a Blade page and an Inertia React page built with [`@javaabu/forms`](https://github.com/Javaabu/react-forms) look the same.

```php
// config/forms.php
'framework' => env('FORMS_FRAMEWORK', 'onu'),
```

## Including the styles

### Apps that build CSS with Tailwind CSS v4 (recommended)

Install Onu and import its Tailwind entry, then the forms entry:

```bash
npm install @javaabu/onu tailwindcss @tailwindcss/vite
```

```css
/* resources/css/app.css */
@import "tailwindcss";
@import "@javaabu/onu/tailwind.css";
@import "../../vendor/javaabu/forms/resources/css/onu.css";
```

`resources/css/onu.css` tells Tailwind to scan the package's Blade views and class map, so only the classes your pages use are built. It also styles the few native controls Onu draws with React (checkboxes, radios, file inputs and `<dialog>`). Every colour, radius and font comes from Onu's tokens, so [theming Onu](https://github.com/Javaabu/onu) themes the forms too.

### Apps without a Tailwind build

The package ships a prebuilt stylesheet with Tailwind, Onu and the forms styles in one file (the `forms::onu` asset, built from `resources/css/onu-standalone.css` into `dist/`). javaabu/manifest adds it to pages with `onu` components while `forms.assets.styles` (`FORMS_STYLES`) is on, which is the default. To serve it as a static file instead of through a route:

```bash
php artisan vendor:publish --tag=manifest-dist
```

It is about 46 KB gzipped, because it contains every Onu class. Use the Tailwind setup above when you can.

## Right-to-left and Dhivehi

Onu uses logical utilities (`ms-`, `pe-`, `start-`), so the components work in RTL pages unchanged. Set `dir="rtl"` and `lang="dv"` on `<html>`; the package's Dhivehi strings load from `lang/dv`.

## How the classes stay in sync with Onu

The Blade views don't copy Onu's class strings by hand. `scripts/onu-classes.mjs` server-renders Onu's own React components and records the classes of every element by its `data-slot`, writing `resources/onu/classes.php`. The views read them through `Javaabu\Forms\Frameworks\Onu`:

```blade
<input class="{{ $frameworkClasses()->classes('input.input') }}" data-slot="input" />
```

CI fails when that file is out of date with the `@javaabu/onu` version in `package.json`. After upgrading Onu, run:

```bash
pnpm install
pnpm onu-classes
pnpm build
```

## Differences from the React components

- **Floating labels** don't exist in Onu. `floating` fields render with the label above, like a normal field.
- **Checkboxes and radios** are native `<input>` elements with Onu's classes, rather than Radix buttons, so they submit with the form without JavaScript.
- **Modals** are native `<dialog>` elements with Onu's modal classes. Open one with the `showModal()` browser API or the package's JavaScript (see [Assets](../advanced-usage/assets.md)).
- **Accordions** use `<details>`/`<summary>`; items in one accordion close each other through the `name` attribute.
