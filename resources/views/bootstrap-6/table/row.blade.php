<tr id="{{ $getRowId() }}" {{ $attributes->merge([]) }}>
    @if(empty($noCheckbox))
        <td class="td-checkbox">
            <input id="{{ $getCheckboxId() }}" data-check="{{ $name }}" name="{{ $name }}[]" value="{{ $modelId }}" class="check" type="checkbox" aria-label="{{ __('forms::strings.select_row') }}" @if($disableCheckbox)disabled @endif />
        </td>
    @endif

    {{ $slot }}
</tr>
