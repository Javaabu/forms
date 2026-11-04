@unless(empty($actions))
    <div class="flex flex-wrap items-start gap-2">
        <div class="w-full md:w-64">
            <div class="mb-2">
                <x-forms::select2
                    name="action"
                    :framework="$framework"
                    :options="['' => ''] + $actions"
                    :placeholder="__('forms::strings.bulk_action')"
                    :show-label="false"
                    hide-search
                    allow-clear
                    required
                />
            </div>
        </div>
        <div>
            <x-forms::button type="submit" color="warning" :framework="$framework">
                {{ __('forms::strings.apply') }}
            </x-forms::button>
        </div>
    </div>

    <x-forms::hidden name="redirect" :value="Request::fullUrl()" :framework="$framework" />
@endunless
