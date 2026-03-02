---
title: Date & Time Components
description: Documentation for date and time input components in the Javaabu Forms package
category: components
order: 3
---

# Date & Time Components

This section covers all date and time related input components including date pickers, datetime fields, and time selections.

---

## Date

**File Path:** `src/Views/Components/Date.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The date field name

**Constructor Parameters:**
- Same as Input component
- `$type` (string): Input type (default: 'date')
- `$dateFormat` (string): Custom date format (default: '')
- `$icon` (string): Icon for the date picker (default: from config)
- `$clearIcon` (string): Clear button icon (default: from config)
- `$clearBtnClass` (string): Clear button CSS class (default: from config)
- `$iconWrapperClass` (string): Icon wrapper CSS class (default: from config)

**Available Methods:**
- `datePickerClass()`: Returns 'date-picker' class
- `isDateInput()`: Returns true
- `formatDateTime($model, $key, $date)`: Formats a date/time value

**Slots:** None

**Example:**
```blade
<x-date name="birth_date" label="Date of Birth" />
```

---

## Datetime

**File Path:** `src/Views/Components/Datetime.php`

**Inherits from:** Date

**Required Parameters:**
- `$name` (string): The datetime field name

**Constructor Parameters:**
- Same as Date component

**Available Methods:**
- `datePickerClass()`: Returns 'datetime-picker' class

**Slots:** None

**Example:**
```blade
<x-datetime name="event_time" label="Event Time" />
```

---

## Time

**File Path:** `src/Views/Components/Time.php`

**Inherits from:** Date

**Required Parameters:**
- `$name` (string): The time field name

**Constructor Parameters:**
- Same as Date component (except `$type` defaults to 'time')

**Available Methods:**
- `datePickerClass()`: Returns 'time-picker' class

**Slots:** None

**Example:**
```blade
<x-time name="start_time" label="Start Time" />
```

---

## Date & Time Usage Examples

### Basic Date Picker
```blade
<x-date name="birth_date" label="Date of Birth" />
```

### Custom Date Format
```blade
<x-date name="event_date" label="Event Date" :date-format="Y-m-d" />
```

### Datetime Picker
```blade
<x-datetime name="event_datetime" label="Event Date and Time" />
```

### Time Picker
```blade
<x-time name="start_time" label="Event Start Time" />
```

### With Model Binding
```blade
<x-date name="birth_date" :model="$user" label="Date of Birth" />
```

### With Required Validation
```blade
<x-date name="start_date" label="Start Date" required />
```

### With Custom Placeholder
```blade
<x-date name="birth_date" label="Date of Birth" placeholder="Select a date" />
```
