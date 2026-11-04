@php($c = $frameworkClasses())
<tr id="{{ $getRowId() }}" {{ $attributes->merge(['class' => $c->classes('table.table-row')]) }} data-slot="table-row">
    @if(empty($noCheckbox))
        <td class="td-checkbox {{ $c->classes('table.table-cell') }} w-px" data-slot="table-cell">
            <input id="{{ $getCheckboxId() }}" data-check="{{ $name }}" name="{{ $name }}[]" value="{{ $modelId }}" class="{{ $c->classes('checkbox.native') }} forms-checkbox" type="checkbox" aria-label="{{ __('forms::strings.select_row', ['name' => $modelId]) }}" @if($disableCheckbox)disabled @endif />
        </td>
    @endif

    {{ $slot }}
</tr>
