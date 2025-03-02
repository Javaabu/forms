@php
$selected_per_page = $per_page ?? request('per_page', get_setting('per_page'));

if (! in_array($selected_per_page, $amounts)) {
    $amounts[$selected_per_page] = $selected_per_page;
}
@endphp

<x-forms::select2 name="per_page" :label="__('Per Page')" :options="$amounts" :default="$selected_per_page"/>
