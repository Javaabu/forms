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

| Attribute | Default | Description |
| --- | --- | --- |
| `enable-elem` | **Required** | Selector of the input element whose value is used for the condition. |
| `enable-value` | **Required** | Value that enables the section when selected. Accepts arrays as well. |
| `hide-fields` | `false` | Whether to also hide the fields when they are disabled. |
| `disable` | `false` | Inverts the behaviour: disables the section when the given value is selected. |
| `enable-checkbox` | `false` | Uses the checked status of the checkbox selected by `enable-elem` to control the section. |
| `json-encode` | `true` for arrays, otherwise `false` | Whether to JSON encode `enable-value`. |


## Disabling an input field depending on a checkbox status
Sometimes, you may want to disable a if a checkbox is checked. This can be done using the `data-toggle-checkbox` attribute. 
This attribute should be set to the selector of the input field you want to disable.

In this example, we will disable the `max_salary` input field if the `any_max_salary` checkbox is checked. 

```html
<x-forms::number name="max_salary" label="Max Salary" />

<x-forms::checkbox name="any_max_salary" :value="1" data-toggle-checkbox="#max-salary" />
```

## Enabling and disabling a section based on checkbox status
You may want to show or hide parts of your UI depending on whether a checkbox is checked. The data-enable-section-checkbox attribute makes this easy to implement.

In the example below, sections are conditionally shown or hidden based on the status of the #existing_user checkbox.

```html

<x-forms::checkbox name="existing_user" :label="__('Existing Public User')" :value="1" :checked="true" inline />

<!-- This section is displayed only when the checkbox is checked -->
<div data-enable-section-checkbox="#existing_user"
         data-hide-fields="true">
    <!-- Content visible when #existing_user is checked -->
</div>

<!-- This section is hidden when the checkbox is checked -->
<div data-enable-section-checkbox="#existing_user"
     data-hide-fields="true"
     data-disable="true">
    <!-- Content hidden when #existing_user is checked -->
</div>
```

**Attribute Explanation:**
- `data-enable-section-checkbox`: Selector for the checkbox that controls the section. 
- `data-hide-fields="true"`: Hides all form fields within the section instead of removing the entire section. 
- `data-disable="true"`: Inverts the logic—disables or hides the section when the checkbox is checked.


### Updated Blade syntax for using the conditional wrapper using Checkbox
```html
<x-forms::conditional-wrapper enable-elem="#online_interview" :enable-value="1" enable-checkbox hide-fields >
    This section is displayed only when the checkbox is checked
</x-forms::conditional-wrapper>

<x-forms::conditional-wrapper enable-elem="#online_interview" :enable-value="1" enable-checkbox hide-fields disable >
    This section is HIDDEN when the checkbox is checked
</x-forms::conditional-wrapper>

```
