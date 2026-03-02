---
title: File & Image Components
description: Documentation for file and image upload components in the Javaabu Forms package
category: components
order: 5
---

# File & Image Components

This section covers all file and image upload components including file inputs, image previews, and media management.

---

## File

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

## Image

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

## FileUpload

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

## ImageUpload

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

## File & Image Usage Examples

### Basic File Upload
```blade
<x-file name="document" label="Upload Document" />
```

### Image Upload with Preview
```blade
<x-image name="avatar" label="Profile Picture" width="200" height="200" />
```

### Image Upload with Circle Crop
```blade
<x-image name="avatar" label="Profile Picture" width="300" height="300" circle />
```

### File with Specific Types
```blade
<x-file
    name="document"
    label="Upload Document"
    type="pdf,doc,docx"
    :extensions="['pdf', 'doc', 'docx']"
    :max-size="5242880"
/>
```

### File with MIME Type Restrictions
```blade
<x-file
    name="document"
    label="Upload Image"
    :mimetypes="['image/jpeg', 'image/png', 'image/gif']"
    :max-size="2097152"
/>
```

### File Upload with Collection
```blade
<x-file
    name="files"
    label="Upload Files"
    collection="documents"
/>
```

### Image Upload with Dimensions
```blade
<x-image
    name="photo"
    label="Upload Photo"
    width="600"
    height="400"
    :maintain-aspect-ratio="true"
/>
```

### Image Upload with Full Width
```blade
<x-image
    name="banner"
    label="Banner Image"
    width="1200"
    height="300"
    :fullwidth="true"
    :cover="true"
/>
```

### Image Upload with Cover Mode
```blade
<x-image
    name="hero_image"
    label="Hero Image"
    width="800"
    height="600"
    :cover="true"
/>
```

### File Upload with Custom Icons
```blade
<x-file
    name="attachment"
    label="Upload Attachment"
    :upload-icon="custom-upload-icon"
    :clear-icon="custom-clear-icon"
/>
```

### Disabled File Upload
```blade
<x-file name="document" label="Document" :disabled="true" />
```

### File Upload with Hint
```blade
<x-file name="document" label="Upload Document" :show-hint="true">
    <x-input-help>Maximum file size: 5MB. Accepted formats: PDF, DOC, DOCX.</x-input-help>
</x-file>
```

### File Upload with Media Conversion
```blade
<x-file
    name="photo"
    label="Upload Photo"
    conversion="thumbnail"
/>
```

### File Upload without Accessor
```blade
<x-file
    name="document"
    label="Document"
    :ignore-accessor="true"
/>
```

### File Upload with JavaScript Errors
```blade
<x-file name="document" label="Document" :show-js-errors="true" />
```

### Multiple File Upload
```blade
<x-file
    name="documents"
    label="Upload Documents"
    :multiple="true"
/>
```

### Image Upload with Custom Aspect Ratio
```blade
<x-image
    name="profile"
    label="Profile Photo"
    :aspect-ratio="16/9"
    width="800"
    height="450"
/>
```
