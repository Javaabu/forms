---
title: Select2
sidebar_position: 3
---


The `select2` component wraps the popular [Select2](https://select2.org/) library. It provides a robust dropdown with search, remote data loading, and dependent/cascading functionality.

## Basic Usage

The simplest usage involves passing an array or collection of options.

```html
<x-forms::select2 name="country" :options="$countries" />
```

### Multiple Select & Tags

To allow multiple selections or custom user-inputted tags:

```html
<!-- Multiple Selection -->
<x-forms::select2 name="roles" :options="$roles" multiple />

<!-- Tags (Allowing custom values) -->
<x-forms::select2 name="skills" :options="$skills" multiple tags />
```
:::info
When `tags` is enabled, any value present in `old()` input that isn't in `$options` will automatically be added to the list.
:::

## Ajax / Remote Data

For large datasets, load options via Ajax as the user types.

1.  Set `is-ajax` to true.
2.  Provide the endpoint via `ajax-url`.

```html
<x-forms::select2 
    name="user_id" 
    :ajax-url="route('api.users.index')" 
    is-ajax 
/>
```

:::warning Be Careful
When using Ajax, the initial page load won't have the "selected" option in the DOM. You **must** manually pre-load the currently selected option into the `:options` attribute so the user sees the existing value.
:::

```html
<x-forms::select2 
    name="user_id" 
    :options="User::where('id', $post->user_id)" 
    :ajax-url="route('api.users.index')" 
    is-ajax 
/>
```

## Cascading Selects (Parent / Child)

You can link multiple selects so that choosing a value in one (Parent) filters the options in the next (Child).

### Step-by-Step

1.  **Parent**: Add `is-first` and specify `child="#child-id"`.
2.  **Child**: Add `filter-field="parent_param_name"` (this is the query param sent to the API).
3.  **Child**: Add `child="#next-child"` if the chain continues.

```html
<x-forms::form :model="$address">
    <!-- 1. Country (Parent) -->
    <x-forms::select2 
        name="country" 
        :options="Country::all()" 
        child="#state" 
        is-first 
    />

    <!-- 2. State (Child of Country) -->
    <!-- `filter-field="country"` means ?country=SELECTED_ID will be sent to states API -->
    <x-forms::select2 
        name="state" 
        id="state"
        :options="State::whereCountryId($address->country_id)" 
        :ajax-url="route('api.states.index')" 
        child="#city" 
        filter-field="country" 
    />

    <!-- 3. City (Child of State) -->
    <x-forms::select2 
        name="city" 
        id="city"
        :options="City::whereStateId($address->state_id)" 
        :ajax-url="route('api.cities.index')" 
        filter-field="state" 
    />
</x-forms::form>
```

### Fallbacks (Manual Input)

Sometimes a child select might return 0 results (e.g., you select a State, but your API has no Cities for it). You can allow the user to manually type a value instead.

To do this:
1.  Create a text input with the `fallback` class.
2.  Link it to the select using `fallback="#id-of-text-input"`.
3.  When the select receives 0 options from the API, it will be disabled and hidden, and the text input will appear.

```html
<x-forms::form :model="$address">
    <!-- 1. Parent -->
    <x-forms::select2 
        name="country" 
        :options="Country::query()" 
        child="#state" 
        is-first 
    />

    <!-- 2. Child -->
    <x-forms::select2 
        name="state" 
        :options="State::whereCountryId($address->country_id)" 
        :ajax-url="route('api.states.index')" 
        child="#city" 
        filter-field="country" 
    />

    <!-- 3. Child with Fallback -->
    <!-- If this returns 0 options, the #city-name input below is shown instead -->
    <x-forms::select2 
        name="city" 
        :options="City::whereStateId($address->state_id)" 
        :ajax-url="route('api.cities.index')" 
        fallback="#city-name" 
        filter-field="state" 
        relation 
    />
    
    <!-- The Fallback Input -->
    <!-- Note: 'name' matches the select above so the server sees 'city' regardless of which input is used -->
    <x-forms::text 
        name="city" 
        id="city-name" 
        class="fallback" 
        :placeholder="__('Write your own city name...')" 
    />

    <x-forms::submit>Submit</x-forms::submit>
</x-forms::form>
```

## Advanced Configuration

### Inside Modals

Select2 has z-index issues inside Bootstrap modals. Use `parent-modal` to fix this.

```html
<x-modal id="create-user-modal">
    <x-forms::select2 name="role" parent-modal="#create-user-modal" ... />
</x-modal>
```

### Clean UI Options

*   **Hide Search**: `hide-search` (useful for small lists).
*   **Disable Clear**: `allow-clear="false"` (default is true).

```html
<x-forms::select2 name="status" :options="$statuses" hide-search :allow-clear="false" />
```

### Dynamic Search URLs (Advanced)

If the **API Endpoint itself** needs to change based on another valid (e.g. Type -> Entity), use `ajax-child` on the parent and dictionary logic on the child.

```html
<!-- Parent changes the 'type' -->
<x-forms::select2 
    name="type" 
    ajax-child="#entity_select" 
    :options="['users' => 'Users', 'posts' => 'Posts']" 
/>

<!-- Child receives different URL based on parent value -->
<x-forms::select2 
    id="entity_select"
    name="entity_id" 
    is-ajax 
    :ajax-url="json_encode([
        'users' => route('api.users.index'),
        'posts' => route('api.posts.index')
    ])" 
/>
```

## Available Options

| Prop | Type | Default | Description |
|---|---|---|---|
| `options` | `iterable` | `[]` | List of options (key => label). |
| `is-ajax` | `bool` | `false` | Enable remote searching via Ajax. |
| `ajax-url` | `string` | `null` | URL or JSON dictionary of URLs for remote data. |
| `multiple` | `bool` | `false` | Allow multiple selections. |
| `tags` | `bool` | `false` | Allow creating new options (tagging). |
| `child` | `string` | `null` | CSS selector of the dependent child select element. |
| `is-first` | `bool` | `false` | Mark as the start of a cascade chain (triggers change events on load). |
| `filter-field` | `string` | `null` | The query parameter name sent to the child's API endpoint. |
| `fallback` | `string` | `null` | CSS selector of a text input to show if no options are returned. |
| `parent-modal` | `string` | `null` | CSS selector of the wrapping modal (fixes z-index). |
| `hide-search` | `bool` | `false` | Hides the search input box. |
| `allow-clear` | `bool` | `true` | Show 'x' button to clear selection. |
