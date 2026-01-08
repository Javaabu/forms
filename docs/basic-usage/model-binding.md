---
title: Model Binding and Default Values
sidebar_position: 2
---


Model binding allows you to populate your forms with data from Eloquent models or other objects automatically.

## Precedence Order

It is important to understand how the component decides which value to show. The priority list is as follows (highest to lowest):

1.  **Old Input**: If a validation error occurred or the form was just submitted, `old('name')` takes top priority.
2.  **Explicit Value**: A hardcoded `:value="..."` attribute.
3.  **Model Binding**: Value derived from a bound Model or Object (e.g., `$user->name`).
4.  **Default Attribute**: The `default="..."` attribute passed to the component.
5.  **Null**: Empty string.

## Binding Methods

### 1. Simple Default Values

For simple use cases where you just want a fallback value:

```html
<x-forms::textarea name="motivation" default="I want to use this package because..." />
```

### 2. Binding (Single Component)

You can bind a specific model to a single component.

```html
<x-forms::input name="title" :model="$post" />
```
*This renders value of `$post->title`.*

### 3. Binding (Whole Form)

Commonly, you'll want to bind an entire form to a model.

```html
<x-forms::form :model="$video">
    <!-- Populates with $video->title -->
    <x-forms::input name="title" />
    
    <!-- Populates with $video->description -->
    <x-forms::textarea name="description" />
</x-forms::form>
```

### 4. The `@model` Directive

If you aren't using the `x-forms::form` component but still want binding scope, use the blade directive.

```html
<div>
    @model($video)
        <x-forms::input name="title" />
        <x-forms::textarea name="description" />
    @endmodel
</div>
```

## Advanced & Nested Binding

You can nest bindings or override them for specific fields.

### Nested Models

Useful when a form handles relations (e.g., User and UserProfile).

```html
<x-forms::form :model="$user">
    <x-forms::input name="full_name" />

    <!-- Switch context to profile -->
    @model($user->profile)
        <x-forms::textarea name="biography" />
    @endmodel

    <!-- Back to $user context -->
    <x-forms::input name="email" />
</x-forms::form>
```

### Breaking the Binding

You can opt-out of binding for a specific field by setting `:model="false"` or providing a specific bound object.

```html
<x-forms::form :model="$video">
    <x-forms::input name="title" />
    
    <!-- Use a different model -->
    <x-forms::input name="category_name" :model="$category" />
    
    <!-- No binding at all -->
    <x-forms::textarea name="comments" :model="false" />
</x-forms::form>
```
