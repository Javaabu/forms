---
title: Input Components
description: Documentation for all input components in the Javaabu Forms package
category: components
order: 2
---

# Input Components

This section covers all input field components including text, email, password, number, textarea, checkbox, radio, and other standard input types for building forms.

## Input

Base input component for various HTML5 input types.

<screenshot />

```blade
<x-input name="email" type="email" label="Email Address" required />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$type` | string | No | 'text' | Input type |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Text

Standard text input for single-line text entry.

<screenshot />

```blade
<x-text name="username" label="Username" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Email

Email input with built-in email validation.

<screenshot />

```blade
<x-email name="email" label="Email Address" required />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Password

Password input with hidden text.

<screenshot />

```blade
<x-password name="password" label="Password" required />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Tel

Telephone number input.

<screenshot />

```blade
<x-tel name="phone" label="Phone Number" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Url

URL input for web addresses.

<screenshot />

```blade
<x-url name="website" label="Website URL" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Number

Numeric input for numbers.

<screenshot />

```blade
<x-number name="age" label="Age" required />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Date

Date picker input for selecting dates.

<screenshot />

```blade
<x-date name="birthday" label="Birthday" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$type` | string | No | 'date' | Input type |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$dateFormat` | string | No | '' | Date format string |
| `$icon` | string | No | '' | Icon class |
| `$clearIcon` | string | No | '' | Clear button icon class |
| `$clearBtnClass` | string | No | '' | Clear button CSS class |
| `$iconWrapperClass` | string | No | '' | Icon wrapper CSS class |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Datetime

Date and time picker input.

<screenshot />

```blade
<x-datetime name="published_at" label="Published At" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$dateFormat` | string | No | '' | Date format string |
| `$icon` | string | No | '' | Icon class |
| `$clearIcon` | string | No | '' | Clear button icon class |
| `$clearBtnClass` | string | No | '' | Clear button CSS class |
| `$iconWrapperClass` | string | No | '' | Icon wrapper CSS class |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Time

Time picker input for selecting times.

<screenshot />

```blade
<x-time name="start_time" label="Start Time" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$icon` | string | No | '' | Icon class |
| `$clearIcon` | string | No | '' | Clear button icon class |
| `$clearBtnClass` | string | No | '' | Clear button CSS class |
| `$iconWrapperClass` | string | No | '' | Icon wrapper CSS class |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## File

File upload input with validation and preview.

<screenshot />

```blade
<x-file name="document" label="Upload Document" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$type` | string/array | No | 'document' | File type(s) |
| `$mimetypes` | string/array | No | null | Allowed MIME types |
| `$extensions` | string/array | No | null | Allowed file extensions |
| `$maxSize` | int | No | null | Maximum file size in bytes |
| `$collection` | string | No | '' | Media collection name |
| `$conversion` | string | No | '' | Media conversion name |
| `$fileInputClass` | string | No | '' | Custom CSS class for file input |
| `$clearIcon` | string | No | '' | Clear button icon class |
| `$downloadIcon` | string | No | '' | Download button icon class |
| `$uploadIcon` | string | No | '' | Upload button icon class |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$showHint` | bool | No | true | Whether to show file hint |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$required` | bool | No | false | Whether field is required |
| `$disabled` | bool | No | false | Whether field is disabled |
| `$ignoreAccessor` | bool | No | false | Whether to ignore model accessor |
| `$upload` | bool | No | false | Whether to show upload button |
| `$inline` | bool | No | false | Whether to render inline |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Textarea

Multi-line text input for longer text content.

<screenshot />

```blade
<x-textarea name="description" label="Description" rows="5" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$rows` | int | No | 3 | Number of rows |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | null | Default value |
| `$value` | mixed | No | null | Value to set |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$placeholder` | string | No | '' | Input placeholder |
| `$showPlaceholder` | bool | No | false | Whether to show placeholder |
| `$wysiwyg` | bool | No | false | Whether to use WYSIWYG editor |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Checkbox

Checkbox input for boolean or multi-select options.

<screenshot />

```blade
<x-checkbox name="agree" label="I agree to the terms" required />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | false | Default value |
| `$value` | mixed | No | 1 | Value when checked |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## Radio

Radio button input for single-select options.

<screenshot />

```blade
<x-radio name="gender" label="Gender" value="male" selected />
<x-radio name="gender" label="Gender" value="female" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | Yes | - | The input field name |
| `$label` | string | No | '' | The field label |
| `$model` | mixed | No | null | The model to bind to |
| `$default` | mixed | No | false | Default value |
| `$value` | mixed | No | 1 | Value when selected |
| `$showErrors` | bool | No | true | Whether to show validation errors |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$required` | bool | No | false | Whether field is required |
| `$inline` | bool | No | false | Whether to render inline |
| `$floating` | bool | No | false | Whether to use floating label style |
| `$inlineLabelClass` | string | No | '' | Custom CSS class for inline labels |
| `$inlineInputClass` | string | No | '' | Custom CSS class for inline input |
| `$showJsErrors` | bool | No | false | Whether to show JavaScript errors |
| `$framework` | string | No | '' | The UI framework |

</details>

## BooleanEntry

Display-only boolean field for showing yes/no values.

<screenshot />

```blade
<x-boolean-entry name="is_active" label="Active" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | No | '' | The field name |
| `$label` | string | No | '' | The field label |
| `$value` | mixed | No | null | The value |
| `$model` | mixed | No | null | The model to bind to |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$inline` | bool | No | false | Whether to render inline |
| `$inlineEntryLabelClass` | string | No | '' | Custom CSS class for inline entry labels |
| `$inlineEntryClass` | string | No | '' | Custom CSS class for inline entry |
| `$framework` | string | No | '' | The UI framework |

</details>

## TextEntry

Display-only text field for showing read-only values.

<screenshot />

```blade
<x-text-entry name="username" label="Username" />
```

<details>
<summary>Parameters</summary>

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$name` | string | No | '' | The field name |
| `$label` | string | No | '' | The field label |
| `$value` | mixed | No | null | The value to display |
| `$model` | mixed | No | null | The model to bind to |
| `$showLabel` | bool | No | true | Whether to show the label |
| `$inline` | bool | No | false | Whether to render inline |
| `$multiline` | bool | No | false | Whether to render multiline |
| `$wysiwyg` | bool | No | false | Whether to use WYSIWYG editor |
| `$inlineEntryLabelClass` | string | No | '' | Custom CSS class for inline entry labels |
| `$inlineEntryClass` | string | No | '' | Custom CSS class for inline entry |
| `$framework` | string | No | '' | The UI framework |

</details>
