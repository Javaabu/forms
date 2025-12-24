@php
    $org = [
        'name' => 'Javaabu'
    ];
@endphp

<table>
    <x-forms::table.row :model="$org">
        <x-forms::table.cell label="Name" name="name" />
    </x-forms::table.row>
</table>