# Laravel Blade Components Documentation

This documentation covers all components provided by the Javaabu Forms package. Each component includes detailed information about its parameters, methods, and usage examples.

---

## Base Components

### Component

**File Path:** `src/Views/Components/Component.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$framework` (string, optional): The UI framework to use (default: from config)

**Available Methods:**
- `id()`: Generates a unique ID for the component
- `label()`: Generates a label based on the component name
- `stringToId($text)`: Converts text to a valid ID
- `getFrameworkIcon($icon)`: Gets the framework icon prefix and format
- `frameworkConfig($config, $default)`: Gets framework-specific configuration

**Slots:** None

**Example:**
```blade
<x-component />
```

---

### FormGroup

**File Path:** `src/Views/Components/FormGroup.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): The form field name
- `$label` (string): The field label (default: '')
- `$required` (bool): Whether the field is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$wrap` (bool): Whether to wrap the field (default: true)
- `$showLabel` (bool): Whether to show the label (default: true)
- `$inlineLabelClass` (string): Custom CSS class for inline labels (default: '')
- `$inlineInputClass` (string): Custom CSS class for inline input (default: '')
- `$blankLabel` (bool): Whether to show blank label (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Methods:**
- `label()`: Returns the label (or empty string if blank)

**Slots:** None

**Example:**
```blade
<x-form-group name="email" label="Email Address" required />
```

---

### Form

**File Path:** `src/Views/Components/Form.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$method` (string): HTTP method (default: 'POST')
- `$model` (mixed): The model to bind to
- `$files` (bool): Whether to handle file uploads (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Properties:**
- `$method`: The HTTP method
- `$spoofMethod`: Whether to spoof the method for PUT/PATCH/DELETE
- `$files`: Whether files are enabled

**Available Methods:**
- `bindModel($model)`: Binds a model to the form

**Slots:** None

**Example:**
```blade
<x-form method="POST" :model="$user" :files="true">
    <!-- Form fields -->
</x-form>
```

---

### FormOpen

**File Path:** `src/Views/Components/FormOpen.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$method` (string): HTTP method (default: 'POST')
- `$model` (mixed): The model to bind to
- `$files` (bool): Whether to handle file uploads (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-form-open method="POST" :model="$user" :files="true">
    <!-- Form fields -->
</x-form-open>
```

---

### FormClose

**File Path:** `src/Views/Components/FormClose.php`

**Slots:** None

**Example:**
```blade
<x-form-open method="POST" :model="$user">
    <!-- Form fields -->
</x-form-open>
<x-form-close />
```

---

## Input Components

### Input

**File Path:** `src/Views/Components/Input.php`

**Required Parameters:**
- `$name` (string): The input field name

**Constructor Parameters:**
- `$name` (string): The input field name
- `$label` (string): The field label (default: '')
- `$type` (string): Input type (default: 'text')
- `$model` (mixed): The model to bind to
- `$default` (mixed): Default value (default: null)
- `$showErrors` (bool): Whether to show validation errors (default: true)
- `$showLabel` (bool): Whether to show the label (default: true)
- `$placeholder` (string): Input placeholder (default: '')
- `$showPlaceholder` (bool): Whether to show placeholder (default: false)
- `$required` (bool): Whether field is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$inlineLabelClass` (string): Custom CSS class for inline labels (default: '')
- `$inlineInputClass` (string): Custom CSS class for inline input (default: '')
- `$showJsErrors` (bool): Whether to show JavaScript errors (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Methods:**
- `datePickerClass()`: Returns date picker class name
- `isDateInput()`: Returns true if this is a date input
- `isFileInput()`: Returns true if this is a file input
- `getDefaultAttributes()`: Returns default attributes for the input

**Slots:** None

**Example:**
```blade
<x-input name="email" type="email" label="Email Address" required />
```

---

### Text

**File Path:** `src/Views/Components/Text.php`

**Inherits from:** Input

**Required Parameters:** `$name` (string)

**Constructor Parameters:**
- Same as Input component

**Example:**
```blade
<x-text name="username" label="Username" />
```

---

### Email

**File Path:** `src/Views/Components/Email.php`

**Inherits from:** Input

**Required Parameters:** `$name` (string)

**Constructor Parameters:**
- Same as Input component

**Example:**
```blade
<x-email name="email" label="Email Address" required />
```

---

### Password

**File Path:** `src/Views/Components/Password.php`

**Inherits from:** Input

**Required Parameters:** `$name` (string)

**Constructor Parameters:**
- Same as Input component

**Example:**
```blade
<x-password name="password" label="Password" required />
```

---

### Tel

**File Path:** `src/Views/Components/Tel.php`

**Inherits from:** Input

**Required Parameters:** `$name` (string)

**Constructor Parameters:**
- Same as Input component

**Example:**
```blade
<x-tel name="phone" label="Phone Number" />
```

---

### Url

**File Path:** `src/Views/Components/Url.php`

**Inherits from:** Input

**Required Parameters:** `$name` (string)

**Constructor Parameters:**
- Same as Input component

**Example:**
```blade
<x-url name="website" label="Website URL" />
```

---

### Number

**File Path:** `src/Views/Components/Number.php`

**Inherits from:** Input

**Required Parameters:** `$name` (string)

**Constructor Parameters:**
- Same as Input component

**Example:**
```blade
<x-number name="age" label="Age" required />
```

---

### Textarea

**File Path:** `src/Views/Components/Textarea.php`

**Inherits from:** Input

**Required Parameters:** `$name` (string)

**Constructor Parameters:**
- `$name` (string): The input field name
- `$label` (string): The field label (default: '')
- `$rows` (int): Number of rows (default: 3)
- `$model` (mixed): The model to bind to
- `$default` (mixed): Default value (default: null)
- `$value` (mixed): Value to set (default: null)
- `$showErrors` (bool): Whether to show validation errors (default: true)
- `$showLabel` (bool): Whether to show the label (default: true)
- `$placeholder` (string): Input placeholder (default: '')
- `$showPlaceholder` (bool): Whether to show placeholder (default: false)
- `$wysiwyg` (bool): Whether to use WYSIWYG editor (default: false)
- `$required` (bool): Whether field is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$inlineLabelClass` (string): Custom CSS class for inline labels (default: '')
- `$inlineInputClass` (string): Custom CSS class for inline input (default: '')
- `$showJsErrors` (bool): Whether to show JavaScript errors (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Methods:**
- `isDateInput()`: Returns false (not a date input)
- `isFileInput()`: Returns false (not a file input)

**Slots:** None

**Example:**
```blade
<x-textarea name="description" label="Description" rows="5" />
```

---

### Checkbox

**File Path:** `src/Views/Components/Checkbox.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The checkbox name

**Constructor Parameters:**
- Same as Input component
- `$default` (mixed): Default value (default: false)
- `$value` (mixed): Value when checked (default: 1)
- `$showJsErrors` (bool): Whether to show JavaScript errors (default: false)

**Available Methods:**
- `isDateInput()`: Returns false (not a date input)
- `isFileInput()`: Returns false (not a file input)

**Slots:** None

**Example:**
```blade
<x-checkbox name="agree" label="I agree to the terms" required />
```

---

### Radio

**File Path:** `src/Views/Components/Radio.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The radio group name

**Constructor Parameters:**
- Same as Input component
- `$default` (mixed): Default value (default: false)
- `$value` (mixed): Value when selected (default: 1)

**Slots:** None

**Example:**
```blade
<x-radio name="gender" label="Gender" value="male" selected />
<x-radio name="gender" label="Gender" value="female" />
```

---

### BooleanEntry

**File Path:** `src/Views/Components/BooleanEntry.php`

**Inherits from:** TextEntry

**Required Parameters:**
- `$name` (string): The field name

**Constructor Parameters:**
- `$name` (string): The field name (default: '')
- `$label` (string): The field label (default: '')
- `$value` (mixed): The value (default: null)
- `$model` (mixed): The model to bind to
- `$showLabel` (bool): Whether to show the label (default: true)
- `$inline` (bool): Whether to render inline (default: false)
- `$inlineEntryLabelClass` (string): Custom CSS class for inline entry labels (default: '')
- `$inlineEntryClass` (string): Custom CSS class for inline entry (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-boolean-entry name="is_active" label="Active" />
```

---

### TextEntry

**File Path:** `src/Views/Components/TextEntry.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): The field name (default: '')
- `$label` (string): The field label (default: '')
- `$value` (mixed): The value to display (default: null)
- `$model` (mixed): The model to bind to
- `$showLabel` (bool): Whether to show the label (default: true)
- `$inline` (bool): Whether to render inline (default: false)
- `$multiline` (bool): Whether to render multiline (default: false)
- `$wysiwyg` (bool): Whether to use WYSIWYG editor (default: false)
- `$inlineEntryLabelClass` (string): Custom CSS class for inline entry labels (default: '')
- `$inlineEntryClass` (string): Custom CSS class for inline entry (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-text-entry name="username" label="Username" />
```

---

## Date & Time Components

### Date

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

### Datetime

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

### Time

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

## Map & Location Components

### MapInput

**File Path:** `src/Views/Components/MapInput.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The map input name

**Constructor Parameters:**
- `$name` (string): The map input name
- `$latName` (string): Name for latitude field (default: 'lat')
- `$lngName` (string): Name for longitude field (default: 'lng')
- `$radiusName` (string): Name for radius field (default: 'radius')
- `$polygonName` (string): Name for boundary polygon field (default: 'boundary')
- `$defaultMapCenterLat` (float): Default map center latitude (default: from config)
- `$defaultMapCenterLng` (float): Default map center longitude (default: from config)
- `$lat` (float): Latitude value
- `$lng` (float): Longitude value
- `$radius` (float): Radius value
- `$polygon` (string): Polygon value
- `$defaultLat` (float): Default latitude
- `$defaultLng` (float): Default longitude
- `$defaultRadius` (float): Default radius
- `$defaultPolygon` (string): Default polygon
- `$disabled` (bool): Whether to disable the map (default: false)
- `$enableCoordinates` (bool): Enable coordinate inputs (default: true)
- `$enableRadius` (bool): Enable radius input (default: false)
- `$enablePolygon` (bool): Enable polygon input (default: false)
- `$hideInputs` (bool): Hide coordinate/radius/polygon inputs (default: false)
- `$radiusPrecision` (int): Radius precision (default: 0)
- `$maxRadius` (int): Maximum radius in meters (default: 6371000)
- `$radiusUnit` (string): Radius unit (default: 'm')
- Same as Input component

**Available Methods:**
- `setLat($name, $bind, $default)`: Set latitude from model
- `setLng($name, $bind, $default)`: Set longitude from model
- `setPolygon($name, $bind, $default)`: Set polygon from model
- `setRadius($name, $bind, $default)`: Set radius from model
- `getRadiusStep()`: Get the step value for radius input

**Slots:** None

**Example:**
```blade
<x-map-input name="location" label="Location" />
```

---

### Latitude

**File Path:** `src/Views/Components/Latitude.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The latitude field name

**Constructor Parameters:**
- Same as Input component

**Available Methods:**
- `getDefaultAttributes()`: Returns array with min=-90, max=90, step=0.000001

**Slots:** None

**Example:**
```blade
<x-latitude name="latitude" label="Latitude" />
```

---

### Longitude

**File Path:** `src/Views/Components/Longitude.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The longitude field name

**Constructor Parameters:**
- Same as Input component

**Available Methods:**
- `getDefaultAttributes()`: Returns array with min=-180, max=180, step=0.000001

**Slots:** None

**Example:**
```blade
<x-longitude name="longitude" label="Longitude" />
```

---

## File & Image Components

### File

**File Path:** `src/Views/Components/File.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The file input name

**Constructor Parameters:**
- `$name` (string): The file input name
- `$label` (string): The field label (default: '')
- `$type` (string|array): File type(s) (default: 'document')
- `$mimetypes` (array): Allowed MIME types (default: from allowed types)
- `$extensions` (array): Allowed extensions (default: from allowed types)
- `$maxSize` (int): Maximum file size in bytes (default: from allowed types)
- `$collection` (string): Media collection name (default: from name)
- `$conversion` (string): Media conversion name (default: '')
- `$fileInputClass` (string): Custom CSS class for file input (default: '')
- `$clearIcon` (string): Clear icon (default: from config)
- `$downloadIcon` (string): Download icon (default: from config)
- `$uploadIcon` (string): Upload icon (default: from config)
- Same as Input component
- `$showHint` (bool): Whether to show hint (default: true)
- `$disabled` (bool): Whether to disable (default: false)
- `$ignoreAccessor` (bool): Whether to ignore accessor (default: false)
- `$upload` (bool): Whether to enable upload (default: false)
- `$showJsErrors` (bool): Whether to show JavaScript errors (default: false)

**Available Methods:**
- `getHint()`: Returns the file upload hint message
- `isFileInput()`: Returns true

**Slots:** None

**Example:**
```blade
<x-file name="document" label="Upload Document" />
```

---

### Image

**File Path:** `src/Views/Components/Image.php`

**Inherits from:** File

**Required Parameters:**
- `$name` (string): The image input name

**Constructor Parameters:**
- Same as File component
- `$icon` (string): Upload icon (default: from config)
- `$width` (int): Maximum width (default: 400)
- `$height` (int): Maximum height (default: 400)
- `$cover` (bool): Cover the area (default: false)
- `$fullwidth` (bool): Full width (default: false)
- `$maintainAspectRatio` (bool): Maintain aspect ratio (default: true)
- `$circle` (bool): Circle crop (default: false)
- Same as File component (except `$upload` defaults to false)
- `$aspectRatio` (float): Aspect ratio (default: calculated)

**Available Methods:**
- `getImageHint()`: Returns the image upload hint message
- `isFileInput()`: Returns true

**Slots:** None

**Example:**
```blade
<x-image name="avatar" label="Profile Picture" width="300" height="300" circle />
```

---

### FileUpload

**File Path:** `src/Views/Components/FileUpload.php`

**Inherits from:** File

**Required Parameters:**
- `$name` (string): The file upload name

**Constructor Parameters:**
- Same as File component
- `$upload` (bool): Whether to enable upload (default: true)
- Same as File component for all other parameters

**Slots:** None

**Example:**
```blade
<x-file-upload name="document" label="Upload Document" />
```

---

### ImageUpload

**File Path:** `src/Views/Components\ImageUpload.php`

**Inherits from:** Image

**Required Parameters:**
- `$name` (string): The image upload name

**Constructor Parameters:**
- Same as Image component
- `$upload` (bool): Whether to enable upload (default: true)
- Same as Image component for all other parameters

**Slots:** None

**Example:**
```blade
<x-image-upload name="avatar" label="Profile Picture" width="400" height="400" />
```

---

## Select Components

### Select

**File Path:** `src/Views/Components/Select.php`

**Required Parameters:**
- `$name` (string): The select field name

**Constructor Parameters:**
- `$name` (string): The select field name
- `$label` (string): The field label (default: '')
- `$placeholder` (string): Placeholder text (default: '')
- `$options` (array|Collection): Options array or query builder
- `$model` (mixed): The model to bind to
- `$default` (mixed): Default value (default: from model)
- `$multiple` (bool): Allow multiple selections (default: false)
- `$relation` (bool): Is this a relation (default: false)
- `$showErrors` (bool): Whether to show validation errors (default: true)
- `$showLabel` (bool): Whether to show the label (default: true)
- `$showPlaceholder` (bool): Whether to show placeholder (default: false)
- `$required` (bool): Whether field is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$isSelect2` (bool): Use Select2 library (default: false)
- `$isAjax` (bool): Use AJAX for options (default: false)
- `$disabled` (bool): Whether to disable (default: false)
- `$excludeSyncField` (bool): Exclude sync field (default: false)
- `$syncFieldName` (string): Sync field name (default: 'sync_{{name}}')
- `$nameField` (string): Name field for options (default: 'name')
- `$idField` (string): ID field for options (default: 'id')
- `$tags` (bool): Allow tag input (default: false)
- `$inlineLabelClass` (string): Custom CSS class for inline labels (default: '')
- `$inlineInputClass` (string): Custom CSS class for inline input (default: '')
- `$formGroupClass` (string): Custom CSS class for form group (default: '')
- `$showJsErrors` (bool): Whether to show JavaScript errors (default: false)
- `$framework` (string): The UI framework (default: '')

**Available Methods:**
- `getOptionsFromQueryBuilder($query)`: Gets options from a query builder
- `isSelected($key)`: Check if a key is selected
- `nothingSelected()`: Check if nothing is selected
- `shouldShowSyncField()`: Check if sync field should be shown

**Slots:** None

**Example:**
```blade
<x-select name="country" label="Country" :options="$countries" />
```

---

### Select2

**File Path:** `src/Views/Components/Select2.php`

**Inherits from:** Select

**Required Parameters:**
- `$name` (string): The select field name

**Constructor Parameters:**
- Same as Select component
- `$allowClear` (bool): Allow clearing selection (default: true)
- `$isFirst` (bool): Is first select in cascade (default: false)
- `$hideSearch` (bool): Hide search bar (default: false)
- `$child` (string): Child select name (default: '')
- `$ajaxChild` (string): AJAX child select name (default: '')
- `$ajaxUrl` (string): AJAX URL (default: '')
- `$selectedUrl` (string): Selected value URL (default: '')
- `$filterField` (string): Filter field (default: '')
- `$fallback` (string): Fallback value (default: '')
- `$parentModal` (string): Parent modal ID (default: '')
- `$iconPrefix` (string): Icon prefix (default: '')
- Same as Select component for all other parameters

**Available Methods:**
- `getNothingSelectedText()`: Returns the "nothing selected" text

**Slots:** None

**Example:**
```blade
<x-select2 name="category" label="Category" :options="$categories" allow-clear />
```

---

## Control Components

### Button

**File Path:** `src/Views/Components/Button.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$type` (string): Button type (default: '')
- `$color` (string): Button color (default: 'primary')
- `$animate` (bool): Whether to add animation (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-button type="submit" color="primary">Submit</x-button>
<x-button type="button" color="danger">Cancel</x-button>
```

---

### Submit

**File Path:** `src/Views/Components/Submit.php`

**Inherits from:** Button

**Required Parameters:** None

**Constructor Parameters:**
- `$color` (string): Button color (default: 'primary')
- `$framework` (string): The UI framework (default: '')

**Example:**
```blade
<x-submit>Save Changes</x-submit>
```

---

### LinkButton

**File Path:** `src/Views/Components/LinkButton.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$url` (string): Button URL (default: '')
- `$color` (string): Button color (default: 'primary')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-link-button url="/users" color="primary">View All Users</x-link-button>
```

---

### ButtonGroup

**File Path:** `src/Views/Components/ButtonGroup.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$inline` (bool): Whether to render inline (default: true)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-button-group inline>
    <x-button>Button 1</x-button>
    <x-button>Button 2</x-button>
</x-button-group>
```

---

## Layout Components

### Card

**File Path:** `src/Views/Components/Card.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$title` (string): Card title (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `header`: Card header slot
- `title`: Card title slot
- `subtitle`: Card subtitle slot
- `footer`: Card footer slot

**Example:**
```blade
<x-card title="Profile Information">
    <x-slot:header>
        <span class="badge">New</span>
    </x-slot:header>

    <!-- Card content -->

    <x-slot:footer>
        <x-button>Save Changes</x-button>
    </x-slot:footer>
</x-card>
```

---

### Accordion

**File Path:** `src/Views/Components/Accordion.php`

**Required Parameters:**
- `$id` (string): The accordion ID

**Constructor Parameters:**
- `$id` (string): The accordion ID
- `$items` (array|Collection): Array of accordion items (default: [])
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual accordion item (named with item index or name)

**Available Methods:**
- `generateSlotByName($name)`: Generates slot name from input name
- `generateCollapseIdByName($name)`: Generates collapse ID from name

**Example:**
```blade
<x-accordion id="accordion" :items="$items">
    <x-slot:item name="details">
        Details content
    </x-slot:item>

    <x-slot:item name="settings">
        Settings content
    </x-slot:item>
</x-accordion>
```

---

### Tabs

**File Path:** `src/Views/Components/Tabs.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$tabs` (array|Collection): Array of tabs (default: [])
- `$active` (string): Active tab name (default: first tab)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `nav-item`: Individual tab navigation item
- `pane`: Individual tab content pane

**Available Methods:**
- `isActive($name)`: Check if tab is active
- `generateSlotByName($name)`: Generate slot name from tab name
- `generateTitleByName($name)`: Generate title from tab name

**Example:**
```blade
<x-tabs :tabs="$tabs" active="profile">
    <x-slot:nav-item name="profile">
        <x-nav-item title="Profile" :active="$tabs->isActive('profile')" />
    </x-slot:nav-item>

    <x-slot:pane name="profile">
        <x-pane :active="$tabs->isActive('profile')">
            Profile content
        </x-pane>
    </x-slot:pane>
</x-tabs>
```

---

### Table

**File Path:** `src/Views/Components/Table.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$framework` (string): The UI framework (default: '')
- `$striped` (bool): Whether table is striped (default: false)
- `$noBulk` (bool): Disable bulk actions (default: false)
- `$model` (string): The model name (default: '')
- `$tableClass` (string): Custom table CSS class (default: '')
- `$filterId` (string): Filter component ID (default: null)
- `$noPagination` (bool): Disable pagination (default: false)
- `$noCheckbox` (bool): Disable checkboxes (default: false)

**Slots:**
- `row`: Table rows
- `cell`: Table cells
- `heading`: Table headings
- `empty-row`: Empty row display

**Available Methods:** None

**Example:**
```blade
<x-table :model="$users" striped>
    <x-slot:heading>
        <x-heading name="id" sortable label="ID" />
        <x-heading name="name" sortable label="Name" />
        <x-heading name="email" sortable label="Email" />
    </x-slot:heading>

    <x-slot:row>
        @foreach($users as $user)
            <x-row :model="$user">
                <x-cell :model="$user" name="id" />
                <x-cell :model="$user" name="name" />
                <x-cell :model="$user" name="email" />
            </x-row>
        @endforeach
    </x-slot:row>
</x-table>
```

---

## Feedback Components

### Alert

**File Path:** `src/Views/Components/Alert.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$type` (string): Alert type (default: 'primary')
- `$dismissible` (bool): Whether alert can be dismissed (default: false)
- `$icon` (string): Icon to display (default: '')
- `$heading` (string): Alert heading (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Alert body content

**Example:**
```blade
<x-alert type="success" dismissible>
    <x-slot:body>
        Your changes have been saved successfully!
    </x-slot:body>
</x-alert>
```

---

### Status

**File Path:** `src/Views/Components/Status.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$label` (string): Status label (default: '')
- `$color` (string): Status color (default: 'primary')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-status label="Published" color="success" />
<x-status label="Draft" color="warning" />
```

---

### NoItems

**File Path:** `src/Views/Components/NoItems.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$createAction` (string): Create action URL (default: '#')
- `$model` (mixed): The model (default: null)
- `$icon` (string): Icon to display (default: from config)
- `$modelType` (string): Model type name (default: null)
- `$showCreate` (bool): Whether to show create button (default: from auth)
- `$title` (string): Title text (default: from translation)
- `$message` (string): Message text (default: from translation)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-no-items :model="$posts" :create-action="route('posts.create')" model-type="Posts" />
```

---

## Navigation Components

### NavTabs

**File Path:** `src/Views/Components/NavTabs.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$tabs` (array|Collection): Array of tabs (default: [])
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual tab item

**Example:**
```blade
<x-nav-tabs :tabs="$tabs">
    <x-slot:item name="profile">
        <x-nav-item title="Profile" />
    </x-slot:item>

    <x-slot:item name="settings">
        <x-nav-item title="Settings" />
    </x-slot:item>
</x-nav-tabs>
```

---

## Form Control Components

### Label

**File Path:** `src/Views/Components/Label.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$label` (string): The label text (default: '')
- `$required` (bool): Whether label is required (default: false)
- `$inline` (bool): Whether to render inline (default: false)
- `$floating` (bool): Whether to use floating label style (default: false)
- `$inlineLabelClass` (string): Custom CSS class (default: '')
- `$blankLabel` (bool): Whether to show blank label (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-label for="email" required>Email Address</x-label>
```

---

### LabelRequired

**File Path:** `src/Views/Components/LabelRequired.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$text` (string): Required text (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-label-required />
```

---

### InputHelp

**File Path:** `src/Views/Components/InputHelp.php`

**Slots:** None

**Example:**
```blade
<x-input-help>Additional information goes here.</x-input-help>
```

---

### Errors

**File Path:** `src/Views/Components/Errors.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): Field name (default: '')
- `$bag` (string): Error bag name (default: 'default')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-errors name="email" bag="default" />
```

---

### JsErrors

**File Path:** `src/Views/Components/JsErrors.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): Field name (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-js-errors name="email" />
```

---

### Wysiwyg

**File Path:** `src/Views/Components/Wysiwyg.php`

**Required Parameters:**
- `$name` (string): The WYSIWYG field name

**Constructor Parameters:**
- Same as Input component

**Slots:** None

**Example:**
```blade
<x-wysiwyg name="content" label="Content" />
```

---

## Utility Components

### Infolist

**File Path:** `src/Views/Components/Infolist.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$title` (string): Card title (default: '')
- `$model` (mixed): The model to display
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual info item
- `title`: Card title slot
- `subtitle`: Card subtitle slot

**Example:**
```blade
<x-infolist :model="$user" title="User Profile">
    <x-slot:item name="email">
        <x-label>📧 Email</x-label>
        <x-text-entry :model="$user" name="email" :show-label="false" />
    </x-slot:item>
</x-infolist>
```

---

### SearchForm

**File Path:** `src/Views/Components/SearchForm.php`

**Required Parameters:**
- `$action` (string): Form action URL
- `$name` (string): Search parameter name (default: 'search')

**Constructor Parameters:**
- `$name` (string): Search parameter name (default: 'search')
- `$action` (string): Form action URL (default: '')
- `$route` (string): Route name for action (default: '')
- `$params` (array): Route parameters (default: [])
- `$placeholder` (string): Search placeholder (default: '')
- `$icon` (string): Search icon (default: from config)
- `$method` (string): HTTP method (default: 'GET')
- `$model` (mixed): The model to bind to (default: request()->query())
- `$files` (bool): Whether to handle files (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-search-form action="/users" placeholder="Search users..." />
```

---

### Filter

**File Path:** `src/Views/Components/Filter.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `item`: Individual filter item

**Example:**
```blade
<x-filter>
    <x-slot:item name="search">
        <x-input name="search" label="Search" />
    </x-slot:item>

    <x-slot:item name="status">
        <x-select name="status" label="Status" :options="$statuses" />
    </x-slot:item>
</x-filter>
```

---

### FilterSubmit

**File Path:** `src/Views/Components/FilterSubmit.php`

**Required Parameters:**
- `$cancelUrl` (string): URL to cancel/filter

**Constructor Parameters:**
- `$cancelUrl` (string): URL to cancel/filter
- `$export` (bool|array): Export actions (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-filter-submit cancel-url="/users" :export="['csv', 'pdf']" />
```

---

### PerPage

**File Path:** `src/Views/Components/PerPage.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$amounts` (array): Page amounts array (default: [10, 20, 50, 100, 500])
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-per-page :amounts="[10, 25, 50, 100]" />
```

---

### BulkActions

**File Path:** `src/Views/Components/BulkActions.php`

**Required Parameters:**
- `$model` (string): The model class name
- `$actions` (array): Array of bulk actions

**Constructor Parameters:**
- `$model` (string): The model class name
- `$actions` (array): Array of bulk actions
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-bulk-actions model="App\Models\User" :actions="$actions">
    <x-select name="action" label="Bulk Action">
        <option value="delete">Delete</option>
        <option value="archive">Archive</option>
    </x-select>
</x-bulk-actions>
```

---

### ConditionalLink

**File Path:** `src/Views/Components/ConditionalLink.php`

**Required Parameters:**
- `$url` (string): The URL to link to

**Constructor Parameters:**
- `$url` (string): The URL to link to
- `$name` (string): Field name to check (default: '')
- `$showLink` (bool|null): Whether to show link (default: null)
- `$can` (string): Permission to check (default: '')
- `$arg` (array): Arguments for permission check (default: [])
- `$guard` (string|null): Auth guard (default: null)
- `$value` (mixed): Value to check (default: from model)
- `$model` (mixed): Model to bind to
- `$multiline` (bool): Whether multiline (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-conditional-link url="/settings" name="is_admin" can="edit_settings">
    Edit Settings
</x-conditional-link>
```

---

### ConditionalWrapper

**File Path:** `src/Views/Components/ConditionalWrapper.php`

**Required Parameters:**
- `$enableElem` (string): Element to check
- `$enableValue` (mixed): Value to enable on

**Constructor Parameters:**
- `$enableElem` (string): Element to check
- `$enableValue` (mixed): Value to enable on
- `$hideFields` (bool): Whether to hide fields (default: false)
- `$disable` (bool): Whether to disable fields (default: false)
- `$enableCheckbox` (bool): Whether to use checkbox (default: false)
- `$jsonEncode` (bool|null): Whether to JSON encode (default: auto-detect)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `checkbox`: Conditional checkbox
- `content`: Conditional content

**Example:**
```blade
<x-conditional-wrapper enable-elem="account_type" enable-value="premium">
    <x-slot:checkbox>
        <x-checkbox name="premium" label="Premium Account" />
    </x-slot:checkbox>

    <x-slot:content>
        Premium features go here...
    </x-slot:content>
</x-conditional-wrapper>
```

---

### Modal

**File Path:** `src/Views/Components/Modal.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$id` (string): Modal ID (default: '')
- `$title` (string): Modal title (default: '')
- `$modalSizeClass` (string): Modal size class (default: null)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `header`: Modal header slot
- `body`: Modal body slot
- `footer`: Modal footer slot

**Example:**
```blade
<x-modal id="confirm-modal" title="Confirm Action">
    <x-slot:body>
        Are you sure you want to proceed?
    </x-slot:body>

    <x-slot:footer>
        <x-button color="danger">Confirm</x-button>
        <x-button color="secondary" @click="$dispatch('close')">Cancel</x-button>
    </x-slot:footer>
</x-modal>
```

---

## Accordion Components

### AccordionItem

**File Path:** `src/Views/Components/Accordion/Item.php`

**Required Parameters:**
- `$name` (string): Item name
- `$parent` (string): Parent accordion ID

**Constructor Parameters:**
- `$name` (string): Item name
- `$parent` (string): Parent accordion ID
- `$title` (string): Item title (default: '')
- `$content` (string): Item content (default: '')
- `$show` (bool): Whether item is open (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `header`: Item header
- `content`: Item content

**Example:**
```blade
<x-accordion-item name="details" parent="accordion" title="Details">
    <x-slot:content>
        Details content here
    </x-slot:content>
</x-accordion-item>
```

---

### AccordionHeader

**File Path:** `src/Views/Components/Accordion/Header.php`

**Required Parameters:**
- `$target` (string): Target collapse ID
- `$title` (string): Header title (default: '')
- `$show` (bool): Whether item is open (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Header body content

**Example:**
```blade
<x-accordion-header target="collapse-1" title="Section 1">
    <x-slot:body>
        Click to expand
    </x-slot:body>
</x-accordion-header>
```

---

### AccordionCollapse

**File Path:** `src/Views/Components/Accordion/Collapse.php`

**Required Parameters:**
- `$parent` (string): Parent accordion ID

**Constructor Parameters:**
- `$parent` (string): Parent accordion ID
- `$content` (string): Collapse content (default: '')
- `$show` (bool): Whether collapse is open (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Collapse body content

**Example:**
```blade
<x-accordion-collapse parent="accordion">
    <x-slot:body>
        <p>Collapse content here</p>
    </x-slot:body>
</x-accordion-collapse>
```

---

## Card Components

### CardHeader

**File Path:** `src/Views/Components/Card/Header.php`

**Slots:**
- `body`: Header body content

**Example:**
```blade
<x-card-header>
    <x-slot:body>
        Card header content
    </x-slot:body>
</x-card-header>
```

---

### CardTitle

**File Path:** `src/Views/Components/Card/Title.php`

**Slots:**
- `body`: Title body content

**Example:**
```blade
<x-card-title>
    <x-slot:body>
        Card Title
    </x-slot:body>
</x-card-title>
```

---

### CardSubtitle

**File Path:** `src/Views/Components/Card/Subtitle.php`

**Slots:**
- `body`: Subtitle body content

**Example:**
```blade
<x-card-subtitle>
    <x-slot:body>
        Card subtitle text
    </x-slot:body>
</x-card-subtitle>
```

---

### CardFooter

**File Path:** `src/Views/Components/Card/Footer.php`

**Slots:**
- `body`: Footer body content

**Example:**
```blade
<x-card-footer>
    <x-slot:body>
        <x-button>Footer Action</x-button>
    </x-slot:body>
</x-card-footer>
```

---

## Tabs Components

### TabsNavItem

**File Path:** `src/Views/Components/Tabs/NavItem.php`

**Required Parameters:**
- `$title` (string): Tab title

**Constructor Parameters:**
- `$title` (string): Tab title
- `$name` (string): Tab name (default: '')
- `$target` (string): Target tab pane (default: '')
- `$url` (string): Tab URL (default: '#')
- `$active` (bool): Whether tab is active (default: false)
- `$disabled` (bool): Whether tab is disabled (default: false)
- `$isTab` (bool): Whether it's a tab (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Tab body content

**Example:**
```blade
<x-tabs-nav-item title="Profile" :active="$tabs->isActive('profile')" />
```

---

### TabsPane

**File Path:** `src/Views/Components/Tabs/Pane.php`

**Required Parameters:**
- `$active` (bool): Whether pane is active

**Constructor Parameters:**
- `$active` (bool): Whether pane is active
- `$name` (string): Pane name (default: '')
- `$target` (string): Target nav item (default: '')
- `$url` (string): Pane URL (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Pane body content

**Example:**
```blade
<x-tabs-pane :active="$tabs->isActive('profile')">
    <x-slot:body>
        Profile content
    </x-slot:body>
</x-tabs-pane>
```

---

## Table Components

### TableHeading

**File Path:** `src/Views/Components/Table/Heading.php`

**Required Parameters:**
- `$label` (string): Heading label

**Constructor Parameters:**
- `$label` (string): Heading label
- `$colspan` (int): Column span (default: 1)
- `$sortable` (string): Sortable field name (default: '')
- `$name` (string): Field name (default: '')
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Heading body content

**Available Methods:**
- `addSortClass($classes)`: Adds sorting class

**Example:**
```blade
<x-table-heading name="name" sortable label="Name" />
```

---

### TableRow

**File Path:** `src/Views/Components/Table/Row.php`

**Required Parameters:**
- `$model` (mixed): Model instance

**Constructor Parameters:**
- `$name` (string): Table name (default: '')
- `$rowId` (string): Row ID (default: '')
- `$model` (mixed): Model instance
- `$modelId` (string): Model ID (default: '')
- `$noCheckbox` (bool): Whether to show checkbox (default: false)
- `$disableCheckbox` (bool): Whether to disable checkbox (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Row body content
- `checkbox`: Row checkbox

**Available Methods:**
- `generateRowId()`: Generate row ID
- `getRowId()`: Get row ID
- `getCheckboxId()`: Get checkbox ID

**Example:**
```blade
<x-table-row :model="$user">
    <x-slot:checkbox>
        <x-checkbox :model="$user" name="ids[]" :value="$user->id" />
    </x-slot:checkbox>

    <x-slot:body>
        <x-cell :model="$user" name="name" />
        <x-cell :model="$user" name="email" />
    </x-slot:body>
</x-table-row>
```

---

### TableCell

**File Path:** `src/Views/Components/Table/Cell.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$name` (string): Field name (default: '')
- `$label` (string): Cell label (default: '')
- `$showLabel` (bool): Whether to show label (default: true)
- `$value` (mixed): Value to display (default: from model)
- `$model` (mixed): Model to bind to
- `$multiline` (bool): Whether multiline (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:**
- `body`: Cell body content

**Available Methods:**
- `formatValue()`: Formats the value

**Example:**
```blade
<x-table-cell name="email" label="Email">
    <x-slot:body>
        {{ $user->email }}
    </x-slot:body>
</x-table-cell>
```

---

### TableEmptyRow

**File Path:** `src/Views/Components/Table/EmptyRow.php`

**Required Parameters:** None

**Constructor Parameters:**
- `$columns` (int): Number of columns (default: 1)
- `$noCheckbox` (bool): Whether to show checkbox (default: false)
- `$framework` (string): The UI framework (default: '')

**Slots:** None

**Example:**
```blade
<x-table-empty-row :columns="3" />
```

---

## Hidden Component

### Hidden

**File Path:** `src/Views/Components/Hidden.php`

**Inherits from:** Input

**Required Parameters:**
- `$name` (string): The hidden field name

**Constructor Parameters:**
- Same as Input component (except `$type` defaults to 'hidden')

**Slots:** None

**Example:**
```blade
<x-hidden name="user_id" value="{{ $user->id }}" />
```

---

## End of Documentation

For more information about this package, visit [Laravel Blade Components Documentation](https://laravel.com/docs/components).
