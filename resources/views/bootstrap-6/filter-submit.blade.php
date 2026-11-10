<div class="d-flex align-items-center gap-2 mb-4">
    {{ $before ?? '' }}

    <x-forms::button color="primary" type="submit" :framework="$framework">
        {{ __('forms::strings.filter') }}
    </x-forms::button>

    @if(! empty($export))
        @if(is_array($export))
            <div class="btn-group">
                <x-forms::button
                    color="secondary"
                    type="submit"
                    name="download"
                    value="{{ array_keys($export)[0] ?? '' }}"
                    :title="__('forms::strings.export_title')"
                    :framework="$framework"
                >
                    {{ __('forms::strings.export') }}
                </x-forms::button>

                <x-forms::button
                    color="secondary"
                    class="menu-toggle-split"
                    type="button"
                    data-bs-toggle="menu"
                    aria-expanded="false"
                    :aria-label="__('forms::strings.export_options')"
                    :framework="$framework"
                >
                    <x-forms::icon name="chevron-down" :framework="$framework" />
                </x-forms::button>
                <div class="menu">
                    @foreach($export as $key => $export_item)
                        <button class="menu-item" type="submit" name="download" value="{{ $key }}">
                            {{ $export_item }}
                        </button>
                    @endforeach
                </div>
            </div>
        @else
            <x-forms::button
                color="secondary"
                type="submit"
                name="download"
                value="1"
                :title="__('forms::strings.export_title')"
                :framework="$framework"
            >
                {{ __('forms::strings.export') }}
            </x-forms::button>
        @endif
    @endif

    {{ $after ?? '' }}

    <x-forms::link-button :url="$cancelUrl" color="light" :framework="$framework">
        {{ __('forms::strings.clear') }}
    </x-forms::link-button>

    {{ $slot }}
</div>
