@unless(empty($actions))
    <div class="row">
        <div class="lg:col-3 md:col-8">
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
        <div class="lg:col-6 md:col-4">
            <x-forms::button type="submit" color="warning" :framework="$framework">
                {{ __('forms::strings.apply') }}
            </x-forms::button>
        </div>
    </div>

    <x-forms::hidden name="redirect" :value="Request::fullUrl()" :framework="$framework" />
@endunless
