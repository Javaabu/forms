---
title: Conditional Wrapper
sidebar_position: 6
---

This component uses [`@javaabu/js-utilities`](https://github.com/Javaabu/js-utilities) `conditionalDisplay` `data-enable-section-value` function to conditionally enable or disable inputs based on another input value.

In the example below, `expires_at` will be disabled and hidden unless the `quiz` option is selected from the `type` select.


```html
<x-forms::select2 :options="['quiz' => __('Quiz'), 'video' => __('Video')]" name="type" />

<x-forms::conditional-wrapper enable-elem="#type" enable-value="quiz" hide-fields="true">
    <x-forms::datetime name="expires_at" />
</x-forms::conditional-wrapper>
```

The conditional wrapper supports the following attributes:
- `'enable-elem'` - (Required) The selector of the input element's value which is used for the condition
- `'enable-value'` - (Required) Which value when selected should the section be enabled. Can accept arrays as well.
- `'hide-fields'` - Whether the fields should also be hidden when they are disabled. Default is `false`.
- `'disable'` - Setting this to `true` will invert the behaviour. i.e The section will get disabled if the given value is selected.
- `'json-encode'` - Whether to json encode the given value. Default is `true` if the given value is an array, otherwise it's false.


## Disabling an input field depending on a checkbox status
Sometimes, you may want to disable a if a checkbox is checked. This can be done using the `data-toggle-checkbox` attribute. 
This attribute should be set to the selector of the input field you want to disable.

In this example, we will disable the `max_salary` input field if the `any_max_salary` checkbox is checked. 

```html
<x-forms::number name="max_salary" label="Max Salary" />

<x-forms::checkbox name="any_max_salary" :value="1" data-toggle-checkbox="#max-salary" />
