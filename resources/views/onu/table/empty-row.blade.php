@php($c = $frameworkClasses())
<tr class="{{ $c->classes('table.table-row') }}" data-slot="table-row">
    <td class="{{ $c->classes('table.table-cell') }} text-center text-muted-foreground" data-slot="table-cell"
        @if ($columns !== null)
            colspan="{{ $noCheckbox ? $columns : ($columns + 1) }}"
        @endif
    >
        {{ $slot }}
    </td>
</tr>
