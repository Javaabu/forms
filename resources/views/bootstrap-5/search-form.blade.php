<x-forms::form :action="route($route, $params)" class="search" :method="$method" :framework="$framework" :files="$files">
    <x-forms::text
        :name="$name"
        :placeholder="$placeholder ?: trans('forms::strings.search_form_placeholder')"
        :show-label="false"
        :framework="$framework"
    />
</x-forms::form>
