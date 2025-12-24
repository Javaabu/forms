@php
    $org = [
        'name' => ['apple' => 'orange']
    ];
@endphp

@model($org)
<table>
    <x-forms::table.cell label="Colors" :value="['orange']" />
</table>
@endmodel