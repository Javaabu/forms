<x-form-group :wrap="$label && $type != 'hidden'" :label="$label" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    <select
        {!! $attributes->merge([
            'class' => 'form-control' . ($hasError($name) ? ' is-invalid' : '') . ($isSelect2 ? ' select2-' . ($isAjax ? 'ajax' : 'basic') : ''),
            'required' => $required
        ]) !!}
        name="{{ $name }}"

        @if($multiple)
            multiple
        @endif

        @if($isSelect2)
            @if($isFirst)
                data-first="true"
            @endif

            @if($child)
                data-select-child="{{ $child }}"
            @endif

            @if($ajaxUrl)
                data-select-ajax-url="{{ $ajaxUrl }}"
            @endif

            @if($nameField)
                data-name-field="{{ $nameField }}"
            @endif

            @if($idField)
                data-id-field="{{ $idField }}"
            @endif

            @if($filterField)
                data-filter-field="{{ $filterField }}"
            @endif

            @if($tags)
                data-tags="true"
            @endif

            @if($allowClear)
                data-allow-clear="true"
            @endif

            @if($hideSearch)
                data-minimum-results-for-search="Infinity"
            @endif

            @if($parentModal)
                data-dropdown-parent-elem="{{ $parentModal }}"
            @endif

            @if($fallback)
                data-fallback="{{ $fallback }}"
            @endif
        @endif

        @if($placeholder)
            @if($isSelect2)
            data-placeholder="{{ $placeholder }}"
            @else
            placeholder="{{ $placeholder }}"
            @endif
        @endif

        @if(($label || $isSelect2) && ! $attributes->get('id'))
            id="{{ $id() }}"
        @endif
    >
        @if($placeholder && ! ($isSelect2 && $multiple))
            <option value="" @if($nothingSelected()) selected="selected" @endif>{{ $placeholder }}</option>
        @endif

        @forelse($options as $key => $option)
            <option value="{{ $key }}" @if($isSelected($key)) selected="selected" @endif>{{ $option }}</option>
        @empty
            {!! $slot !!}
        @endforelse
    </select>

    <i class="form-group__bar"></i>

    @if(! empty($help))
        <x-form-help :framework="$framework">
            {!! $help !!}
        </x-form-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-form-errors :framework="$framework" :name="$name" />
    @endif
</x-form-group>
