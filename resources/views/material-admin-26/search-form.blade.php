<x-forms::form :action="route($route, $params)" class="search" :method="$method" :framework="$framework" :files="$files">
    <div class="search__inner">
        <x-forms::text
            :name="$name"
            :placeholder="$placeholder ?: trans('forms::search_form_placeholder')"
            class="search__text"
            :show-label="false"
            :framework="$framework"
        />
        <i class="{{ $icon }} search__helper" data-ma-action="search-close"></i>
    </div>
</x-forms::form>
