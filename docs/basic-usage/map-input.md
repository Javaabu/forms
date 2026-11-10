---
title: Map input
sidebar_position: 11
---

# Map input

`<x-forms::map-input>` renders latitude and longitude fields, and optionally a radius and a boundary polygon, with a Google Map and a place search box above the map. It reads values from [`matanyadaev/laravel-eloquent-spatial`](https://github.com/MatanYadaev/laravel-eloquent-spatial) `Point` and `Polygon` attributes.

```blade
<x-forms::form method="PATCH" :action="route('islands.update', $island)" :model="$island">
    <x-forms::map-input name="coordinates" label="ތަން" />
</x-forms::form>
```

This submits `lat` and `lng`. Save them as a point:

```php
use MatanYadaev\EloquentSpatial\Objects\Point;

$island->coordinates = new Point($request->float('lat'), $request->float('lng'));
```

## Setting up

1. Install the spatial package: `composer require matanyadaev/laravel-eloquent-spatial`, and cast the attributes (`'coordinates' => Point::class`, `'boundary' => Polygon::class`).
2. Set your Google Maps API key:

    ```dotenv
    MAP_API_KEY=your-key
    ```

3. Render the `scripts` stack in your layout before `</body>`. The component pushes the Google Maps loader to it once per page:

    ```blade
        @stack('scripts')
    </body>
    ```

The component outputs a container with `data-map-selector` and the map settings as `data-` attributes, with the fields inside it (`.map-selector-lat`, `.map-selector-lng`, `.map-selector-radius`, `.map-selector-polygon`, `.map-selector-search`, `.map-selector-map`). The package's assets don't include the map picker script itself: load the map selector from [`@javaabu/js-utilities`](https://github.com/Javaabu/js-utilities) to make the map interactive. See [Assets](../advanced-usage/assets.md#third-party-scripts).

## Radius and boundary

```blade
<x-forms::map-input name="coordinates" enable-radius enable-polygon />
```

- `enable-radius` adds a radius field (submitted as `radius`), in metres. Set `radius-unit="km"` to show "km" after it, `max-radius` to limit it and `radius-precision` for decimal places (`2` gives a step of `0.01`).
- `enable-polygon` adds a boundary textarea (submitted as `boundary`) holding the polygon as WKT, `POLYGON((73.5092 4.1758, …))`.
- `:enable-coordinates="false"` leaves out the point, for a boundary-only field.

## Field names

Change the submitted names with `lat-name`, `lng-name`, `radius-name` and `polygon-name`. The values are read from model attributes with the same names:

```blade
<x-forms::map-input
    name="location"
    lat-name="location_lat"
    lng-name="location_lng"
    polygon-name="area"
    enable-polygon
/>
```

## Where the values come from

For the latitude (the others work the same way):

1. `lat`, if given.
2. Old input or the bound model's `lat-name` attribute, then `default-lat`.
3. The `latitude` of the `Point` in the `name` attribute.

The boundary reads `polygon-name`; a `Polygon` is converted to WKT. The radius reads `radius-name`.

```blade
<x-forms::map-input name="coordinates" :default-lat="4.1755" :default-lng="73.5093" />
```

## Map centre

An empty map is centred on `default-map-center-lat` and `default-map-center-lng`. Without them it uses `forms.defaults.default_lat` and `default_lng`, then the `default_lat` and `default_lng` settings from `javaabu/settings` when it's installed, then Malé (4.1755, 73.5093).

```php
// config/forms.php
'defaults' => [
    'default_lat' => 4.2167,  // Hulhumalé
    'default_lng' => 73.5404,
],
```

## Hiding the fields

`hide-inputs` turns the fields into hidden inputs, so the user picks on the map only:

```blade
<x-forms::map-input name="coordinates" hide-inputs required />
```

## Attributes

| Attribute | Type | Default | Description |
| --- | --- | --- | --- |
| `name` | `string` | required | The `Point` attribute, and the key for the field's errors. |
| `label` | `string` | from `name` | Label of the whole field. |
| `lat-name` | `string` | `'lat'` | Name of the latitude field. |
| `lng-name` | `string` | `'lng'` | Name of the longitude field. |
| `radius-name` | `string` | `'radius'` | Name of the radius field. |
| `polygon-name` | `string` | `'boundary'` | Name of the boundary field. |
| `enable-coordinates` | `bool` | `true` | Shows the latitude and longitude fields and the marker. |
| `enable-radius` | `bool` | `false` | Shows the radius field. |
| `enable-polygon` | `bool` | `false` | Shows the boundary field. |
| `hide-inputs` | `bool` | `false` | Renders the fields as hidden inputs. |
| `radius-unit` | `string` | `'m'` | `m` or `km`, shown after the radius. |
| `radius-precision` | `int` | `0` | Decimal places of the radius. |
| `max-radius` | `int` | `6371000` | Largest radius. |
| `lat`, `lng`, `radius`, `polygon` | `float` / `string` | `null` | Values that replace everything else. |
| `default-lat`, `default-lng`, `default-radius`, `default-polygon` | `float` / `string` | `null` | Values when there is no old input and no model value. |
| `default-map-center-lat` | `float` | config | Latitude the empty map is centred on. |
| `default-map-center-lng` | `float` | config | Longitude the empty map is centred on. |
| `model` | `mixed` | bound model | Model to read from. `false` turns binding off. |
| `required` | `bool` | `false` | Requires the fields. |
| `disabled` | `bool` | `false` | Disables the fields and the map. |
| `show-label` | `bool` | `true` | `false` removes the label and field wrapper. |
| `show-errors` | `bool` | `true` | Shows the errors for `name`. The inner fields show their own. |
| `inline` | `bool` | `false` | Label beside the map. |
| `inline-label-class` | `string` | config | Classes for the label column. |
| `inline-input-class` | `string` | config | Classes for the control column. |
| `form-group-class` | `string` | `''` | Classes on the field wrapper. |
| `show-js-errors` | `bool` | `false` | Adds an empty error list for JavaScript validation. |
| `framework` | `string` | config | `onu` or `bootstrap-6`. |

Other attributes go on the `data-map-selector` container. Slot: `help`.

## React

```jsx
import { MapInput } from "@javaabu/forms"

<MapInput name="coordinates" label="ތަން" enableRadius enablePolygon />
```

See [Parity](../parity.md).
