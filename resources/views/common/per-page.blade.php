@php
$selected_per_page = $perPage ?? $per_page ?? request('per_page', \Javaabu\Forms\Support\Settings::get('per_page', 20));

if (! in_array($selected_per_page, $amounts)) {
    $amounts[$selected_per_page] = $selected_per_page;
}
@endphp

<x-forms::select2
    name="per_page"
    :options="$amounts"
    :default="$selected_per_page"
    :label="$label()"
    :show-label="$showLabel"
    :framework="$framework"
    {{ $attributes }}
/>
