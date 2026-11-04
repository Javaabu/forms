<div class="flex items-center gap-2 mb-4">
    {{ $before ?? '' }}

    <x-forms::button color="primary" type="submit" :framework="$framework">
        {{ __('forms::strings.filter') }}
    </x-forms::button>

    @if(! empty($export))
        @if(is_array($export))
            <x-forms::button-group :framework="$framework">
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

                <details class="relative" data-forms-menu>
                    <summary
                        class="{{ $frameworkClasses()->button('secondary') }} list-none [&::-webkit-details-marker]:hidden"
                        aria-label="{{ __('forms::strings.export_options') }}"
                    >
                        <x-forms::icon name="chevron-down" :framework="$framework" />
                    </summary>
                    <div class="absolute end-0 z-50 mt-1 min-w-40 rounded-lg bg-popover p-1 text-popover-foreground shadow-popup ring-1 ring-border" role="menu">
                        @foreach($export as $key => $export_item)
                            <button class="flex w-full items-center rounded-md px-2 py-1.5 text-start text-sm hover:bg-accent hover:text-accent-foreground" role="menuitem" type="submit" name="download" value="{{ $key }}">
                                {{ $export_item }}
                            </button>
                        @endforeach
                    </div>
                </details>
            </x-forms::button-group>
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
