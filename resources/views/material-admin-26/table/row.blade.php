<tr id="{{ $getRowId() }}">
    @if(empty($noCheckbox))
        <td class="td-checkbox">
            <div class="checkbox">
                <input id="{{ $getCheckboxId() }}" data-check="{{ $name }}" name="{{ $name }}[]" value="{{ $modelId }}" type="checkbox" />
                <label  class="checkbox__label" for="{{ $getCheckboxId }}"></label>
            </div>
        </td>
    @endif

    {{ $slot }}
</tr>

