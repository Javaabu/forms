<tr id="{{ $getRowId() }}" {{ $attributes->merge([]) }}>
    @if(empty($noCheckbox))
        <td>
            <div class="form-check">
                <input id="{{ $getCheckboxId() }}" data-check="{{ $name }}" name="{{ $name }}[]" value="{{ $modelId }}" class="form-check-input" type="checkbox" @if($disableCheckbox)disabled @endif />
                <label for="{{ $getCheckboxId() }}" class="form-check-label"></label>
            </div>
        </td>
    @endif

    {{ $slot }}
</tr>
