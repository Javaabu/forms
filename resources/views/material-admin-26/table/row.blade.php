<tr id="{{ $getRowId() }}" {{ $attributes->merge([]) }}>
    @if(empty($noCheckbox))
        <td class="td-checkbox">
            <div class="checkbox">
                <input id="{{ $getCheckboxId() }}" data-check="{{ $name }}" name="{{ $name }}[]" value="{{ $modelId }}" type="checkbox" @if($disableCheckbox)disabled @endif />
                <label  class="checkbox__label" for="{{ $getCheckboxId }}"></label>
            </div>
        </td>
    @endif

    {{ $slot }}
</tr>

