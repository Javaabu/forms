---
title: Select2
sidebar_position: 3
---

This package supports [Select2](https://select2.org/) JS library and Javaabu's `select2-custom` data attributes.
To use Select2, you must use the `select2` component instead of the standard `select` component. This will generate a select element with the `select2-basic` class applied.

```html
<x-forms::select2 name="country" :options="$countries" />
```

# Using Ajax

To load the select options from Ajax as you type, you must use the `is-ajax` attribute and provide an API url using the `ajax-url` attribute.
When using Ajax, make sure the initial options include the current selected value.

```html
<x-forms::form :model="$address">
    <x-forms::select2 name="country" :label="__('Country')" :options="Country::whereId(isset($address) ? $address->country_id : old('country'))" :ajax-url="route('api.countries.index')" is-ajax />
</x-forms::form>
```

You can use the `id-field` and `name-field` attributes to customize the fields that are used to retrieve the options in the API request.

# Disabling allow clear 

By default, all select2 elements will have the `data-allow-clear` option enabled which will show a button to clear the current selection.
You can disabled this feature by setting `allow-clear` attribute to `false`.

```html
<x-forms::select2 name="country" :options="$countries" :allow-clear="false" />
```

# Hiding the search box

If you want to hide the search box for a select2 element, use the `hide-search` attribute.
This would add `data-minimum-results-for-search="Infinity"` to the select element, which will disable the search feature.

```html
<x-forms::select2 name="country" :options="$countries" hide-search />
```

# Enabling tags

To enable the user to add their own options to the select, enable the `tags` feature of Select2 by using the `tags` attribute. 
When you use the `tags` option, any old values will automatically get added to the options if there's a validation error.

```html
<x-forms::select2 name="categories" :options="$options" multiple tags />
```

# Using Select2 inside a modal

When using a select2 element inside a modal, remember to use the `parent-modal` attribute to specify the selector of the modal to properly render the select2 element.

```html
<x-modal id="your-modal">
    <x-forms::select2 name="country" :options="$countries" parent-modal="#your-modal" />
</x-modal>
```

# Setting up a Select2 cascade

If you want to setup a cascade of selects that depends on each other, use the `is-first` attribute on the first select in the cascade and use the `child` attribute to specify its child select.
Then on the child select, use the `filter-field` attribute to specify the field name that's used to filter the results in the API request.

Notice that here `ajax-url` is used without setting `is-ajax` to true. The reason for this is we want the options of the children elements to be loaded only when a parent element's selected value changes, but we don't want the children elements' options to change as we search inside their select2 search boxes. 

```html
<x-forms::form :model="$address">
    <x-forms::select2 name="country" :options="Country::query()" child="#state" is-first />

    <x-forms::select2 name="state" :options="State::whereCountryId($address->country?->id ?? null)" :ajax-url="route('api.states.index')" child="#city" filter-field="country" />

    <x-forms::select2 name="city" :options="City::whereStateId($address->state?->id ?? null)" :ajax-url="route('api.cities.index')" filter-field="state" relation />

    <x-forms::submit>Submit</x-forms::submit>
</x-forms::form>
```

You can use the `fallback` attribute to specify a `text` input that would be displayed instead of a select when a child select receives 0 options from the API. 
This will allow users to enter their own values if no options are available. When a fallback is active, its associated select will be disabled. Remember to add the `fallback` class to the fallback element. 

```html
<x-forms::form :model="$address">
    <x-forms::select2 name="country" :options="Country::query()" child="#state" is-first />

    <x-forms::select2 name="state" :options="State::whereCountryId($address->country?->id ?? null)" :ajax-url="route('api.states.index')" child="#city" filter-field="country" />

    <x-forms::select2 name="city" :options="City::whereStateId($address->state?->id ?? null)" :ajax-url="route('api.cities.index')" fallback="#city-name" filter-field="state" relation />
    
    <x-forms::text name="city" id="city-name" class="fallback" :placeholder="__('Write your own city name...')" />

    <x-forms::submit>Submit</x-forms::submit>
</x-forms::form>
```
# Configuring a Select2 element to search from multiple URLs

You can configure a Select2 element to be able to search from multiple URLs, depending on the selected value of another select element. 

Imagine you want to build a menu builder for your application, and you want to allow users to be able to select a menu item type (e.g. courses, job listings, employers) and then search for the items of that type.

You can do this by using the `ajax-child` and `is-first` attribute on the type select field, and then use `is-ajax`, `ajax-url` and `selected-url` attributes on the child select field.

```html
@php
    $menu_item_types = ['jobs' => 'Jobs', 'employers' => 'Employers'];
    $urls = ['jobs' => 'https://example.com/api/jobs', 'employers' => 'https://example.com/api/employers'];
@endphp

<x-forms::select2
    name="post_type"
    :options="$menu_item_types"
    ajax-child="#model_id"
    is-first
    allow-clear
    placeholder="Nothing Selected"
/>

<x-forms::select2
    name="post_id"
    is-ajax
    :ajax-url="json_encode($urls)"
    placeholder="Select a post to link"
    allow-clear
    selected-url=""
/>

```
