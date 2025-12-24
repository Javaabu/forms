@php
    $org = [
        'name' => "Javaabu\nCompany"
    ];
@endphp

@model($org)
<table>
    <x-forms::table.cell label="Name" name="name" multiline />
</table>
@endmodel