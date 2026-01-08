---
title: Introduction
sidebar_position: 1.0
---

# Forms

Welcome to the **Javaabu Forms** package documentation. This package provides a robust set of Laravel Blade components designed to simplify and accelerate form creation in your applications.

Inspired by [protonemedia/laravel-form-components](https://github.com/protonemedia/laravel-form-components), this package aims to reduce boilerplate code while maintaining flexibility and ease of customization.

## Key Features

- **Semantic Syntax**: Use clean `<x-forms::input />` syntax instead of verbose HTML.
- **Automatic Model Binding**: Seamlessly bind Eloquent models to forms.
- **Built-in Validation**: Automatically displays validation errors for each field.
- **Framework Agnostic**: Supports Bootstrap 5 and Material Admin 26 out of the box, with options to customize.
- **Rich Components**: Includes specialized components for dates, files, select2, and more.
- **Zero-Config Defaults**: Works immediately with sensible defaults, but fully publishable for deep customization.

## Quick Example

Here is a glimpse of how clean your forms can look:

```html
<x-forms::form :model="$page">
    <x-forms::input name="title" :label="__('Title')" required />
    <x-forms::textarea name="content" :label="__('Content')" rows="5" />
    
    <x-forms::submit>Save Changes</x-forms::submit>
</x-forms::form>
```

## Next Steps

Ready to get started?

1. Head over to the [Installation & Setup](./installation-and-setup) guide to add the package to your project.
2. Explore the [Basic Usage](./basic-usage/inputs-and-textarea) to understand the core components.
