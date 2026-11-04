<x-forms::form-group
    :inline-input-class="$inlineInputClass"
    :inline-label-class="$inlineLabelClass"
    :class="$formGroupClass"
    :wrap="$showLabel"
    :label="$label ?: $label()"
    :name="$attributes->get('id') ?: $id()"
    :framework="$framework"
    :inline="$inline"
    :required="$required"
    :floating="$floating"
>
    @php($c = $frameworkClasses())
    @if((! empty($prepend)) || (! empty($append)))
        <div class="{{ $c->classes('input_group.input-group') }}" data-slot="input-group" role="group">
            @if(! empty($prepend))
                <div class="{{ $c->classes('input_group.input-group-addon') }}" data-slot="input-group-addon" data-align="inline-start">
                    <span class="{{ $c->classes('input_group_text') }}">{{ $prepend }}</span>
                </div>
            @endif
    @endif

    <div class="{{ str_replace('w-fit', 'w-full', $c->classes('select.native-select-wrapper')) }}" data-slot="native-select-wrapper">

    <select
        {!! $attributes->merge([
            'class' => $c->classes('select.native-select') . ($hasError($name) ? ' is-invalid' : '') . ($isSelect2 ? ' select2-' . ($isIconSelect ? 'b-icon' : ($isAjax ? 'ajax' : 'basic')) : ''),
            'required' => $required,
            'disabled' => $disabled,
            'aria-invalid' => $hasError($name) ? 'true' : null,
        ]) !!}
        data-slot="native-select"
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
            <option value="" class="{{ $c->classes('select.native-select-option') }}" @if($nothingSelected()) selected="selected" @endif>{{ $placeholder }}</option>
        @endif

        @forelse($options as $key => $option)
            <option value="{{ $key }}" class="{{ $c->classes('select.native-select-option') }}" @if($isSelected($key)) selected="selected" @endif>{{ $option }}</option>
        @empty
            {!! $slot !!}
        @endforelse
    </select>
        @unless($multiple)
            <x-forms::icon name="chevron-down" :framework="$framework" :class="trim(str_replace(['lucide lucide-chevron-down'], '', $c->classes('select.native-select-icon')))" data-slot="native-select-icon" />
        @endunless
    </div>

    @if((! empty($prepend)) || (! empty($append)))
        @if(! empty($append))
            <div class="{{ $c->classes('input_group.input-group-addon') }}" data-slot="input-group-addon" data-align="inline-end">
                <span class="{{ $c->classes('input_group_text') }}">{{ $append }}</span>
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

    @if($showJsErrors)
        <x-forms::js-errors :framework="$framework" :name="$name" />
    @endif
</x-forms::form-group>

@if($shouldShowSyncField())
    <x-forms::hidden :name="$syncFieldName" :framework="$framework" value="1" />
@endif

@if($isSelect2)
    @include('forms::partials.assets', ['assets' => ['select']])
@endif
