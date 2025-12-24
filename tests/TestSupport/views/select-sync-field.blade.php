<x-forms::form>
    <x-forms::select name="exclude_sync[]" multiple exclude-sync-field>
        <option value="a">A</option>
    </x-forms::select>

    <x-forms::select name="disabled_sync[]" multiple disabled>
        <option value="a">A</option>
    </x-forms::select>

    <x-forms::select name="custom_sync[]" multiple sync-field-name="custom_sync_name">
        <option value="a">A</option>
    </x-forms::select>
</x-forms::form>