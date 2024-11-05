<x-forms::form-group :inline-input-class="$inlineInputClass" :inline-label-class="$inlineLabelClass" :wrap="$showLabel" :label="$label ?: $label()" :name="$attributes->get('id') ?: $id()" :framework="$framework" :inline="$inline" :required="$required" :floating="$floating">
    @if((! empty($prepend)) || (! empty($append)))
        <div class="input-group mb-0">
            @if(! empty($prepend))
                <div class="input-group-prepend">
                {{ $prepend }}
                </div>
            @endif
    @endif

    <select
        {!! $attributes->merge([
        'class' => implode(' ', [
            'form-control',
            $hasError($name) ? 'is-invalid' : '',
            $isSelect2 ? 'select2-' . ($isIconSelect ? 'b-icon' : ($isAjax ? 'ajax' : 'basic')) : '',
        ]),
            'required' => $required,
            'disabled' => $disabled,
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

            @if($ajaxChild)
                data-ajax-child="{{ $ajaxChild }}"
            @endif

            @if($ajaxUrl)
                data-select-ajax-url="{{ $ajaxUrl }}"
            @endif

            @if($selectedUrl)
                data-selected-url="{{ $selectedUrl }}"
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

            @if($iconPrefix)
                data-icon-prefix="{{ $iconPrefix }}"
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

    @if((! empty($prepend)) || (! empty($append)))
        @if(! empty($append))
            <div class="input-group-append">
            {{ $append }}
            </div>
        @endif
        </div>
    @endif

    @if(! empty($help))
        <x-forms::input-help :framework="$framework">
            {!! $help !!}
        </x-forms::input-help>
    @endif

    @if($hasErrorAndShow($name))
        <x-forms::errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>

@if($shouldShowSyncField())
    <x-forms::hidden :name="$syncFieldName" :framework="$framework" value="1" />
@endif
