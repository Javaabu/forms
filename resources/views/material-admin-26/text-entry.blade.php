<dl {!! $attributes->merge(['class' => 'mb-1'.($inline ? ' row' : '')]) !!}>
    @if($showLabel)
        <dt
            @if($inline)
            class="{{ $inlineEntryLabelClass }}"
            @endif
        >{{ $label ?: $label() }}</dt>
    @endif

    <dd
        @if($inline)
        class="{{ $inlineEntryClass }}"
        @endif
    >
        @if($slot->isNotEmpty())
            {{ $slot }}
        @elseif($isAdminModel())
            {!! $value->admin_link !!}
        @elseif($isAdminModelCollection())
            {!! $value->implode('admin_link', trans('forms::strings.table_array_separator')) !!}
        @else
            @if($isStatusEnum())
                <x-forms::status :framework="$framework" :color="$value->getColor()" :label="$getEnumLabel()" />
            @elseif($multiline)
                {!! nl2br(e($value ?: trans('forms::strings.blank'))) !!}
            @elseif(is_array($value))
                <ul class="list list--check">
                    @foreach($value as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @elseif($value && $wysiwyg)
                {!! $value !!}
            @else
                {{ empty($value) && (! is_numeric($value)) ? trans('forms::strings.blank') : $value }}
            @endif
        @endif
    </dd>
</dl>
