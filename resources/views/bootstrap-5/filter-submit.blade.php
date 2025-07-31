<div class="button-group inline-btn-group">
    {{ $before ?? '' }}

    <x-forms::button color="primary" type="submit">
        {{ __('Filter') }}
    </x-forms::button>

    @if(! empty($export))
        @if(is_array($export))
            <div class="btn-group">
                <x-forms::button
                    color="secondary"
                    type="submit"
                    name="download"
                    value="{{ array_keys($export)[0] ?? '' }}"
                    title="Export to XLSX"
                >
                    {{ __('Export') }}
                </x-forms::button>

                <x-forms::button
                    color="secondary"
                    class="dropdown-toggle dropdown-toggle-split"
                    type="button"
                    data-toggle="dropdown"
                >
                    <span class="caret"></span>
                </x-forms::button>
                <ul class="dropdown-menu btn--raised">
                    @foreach($export as $key => $export_item)
                        <li>
                            <x-forms::button
                                color="secondary"
                                class="dropdown-item"
                                type="submit"
                                name="download"
                                value="{{ $key }}"
                            >
                                {{ $export_item }}
                            </x-forms::button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <x-forms::button
                color="secondary"
                type="submit"
                name="download"
                value="1"
                title="Export to XLSX"
            >
                {{ __('Export') }}
            </x-forms::button>
        @endif
    @endif

    {{ $after ?? '' }}

    <x-forms::link-button :url="$cancelUrl" color="light">
        {{ __('Clear') }}
    </x-forms::link-button>

    {{ $slot }}
</div>
