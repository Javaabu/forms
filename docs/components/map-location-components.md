---
title: Map & Location Components
description: Documentation for map and location input components in the Javaabu Forms package
category: components
order: 4
---

# Map & Location Components

This section covers all map and location related input components including map inputs, latitude, and longitude fields.

---

## MapInput

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

## Latitude

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

## Longitude

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

## Map & Location Usage Examples

### Basic Map Input
```blade
<x-map-input name="location" label="Location" />
```

### With Model Binding
```blade
<x-map-input name="location" :model="$address" />
```

### Custom Radius Input
```blade
<x-map-input
    name="location"
    label="Location with Radius"
    :enable-radius="true"
    :radius-unit="'km'"
    :max-radius="50000"
/>
```

### Polygon Boundary
```blade
<x-map-input
    name="service_area"
    label="Service Area"
    :enable-polygon="true"
    :hide-inputs="true"
/>
```

### Coordinates Only
```blade
<x-map-input
    name="coordinates"
    label="Coordinates"
    :hide-inputs="true"
    :enable-coordinates="false"
/>
```

### Custom Map Center
```blade
<x-map-input
    name="location"
    label="Location"
    :default-map-center-lat="40.7128"
    :default-map-center-lng="-74.0060"
/>
```

### Custom Radius Fields
```blade
<x-map-input
    name="service_area"
    label="Service Area"
    lat-name="service_area_lat"
    lng-name="service_area_lng"
    radius-name="service_area_radius"
/>
```

### Latitude Only
```blade
<x-latitude name="latitude" label="Latitude" />
```

### Longitude Only
```blade
<x-longitude name="longitude" label="Longitude" />
```

### Custom Latitude Constraints
```blade
<x-latitude
    name="latitude"
    label="Latitude"
    :min="-85"
    :max="85"
    :step="0.0001"
/>
```

### Custom Longitude Constraints
```blade
<x-longitude
    name="longitude"
    label="Longitude"
    :min="-180"
    :max="180"
    :step="0.0001"
/>
```

### Combined Coordinates
```blade
<div class="form-group">
    <x-label name="location" label="Location Coordinates" />
    <x-latitude name="latitude" />
    <x-longitude name="longitude" />
</div>
```
