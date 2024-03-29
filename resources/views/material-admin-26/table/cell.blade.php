<td {{ $attributes->merge([]) }}
    @if($showLabel && $name)
    data-col="{{ $label ?: $label() }}"
    @endif
>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @elseif($isAdminModel())
        {!! $value->admin_link !!}
    @else
        @if($multiline)
            {!! nl2br(e($value ?: trans('forms::strings.blank'))) !!}
        @elseif(is_array($value))
            {{ implode(trans('forms::table_array_separator'), $value) }}
        @else
            {{ $formatValue() }}
        @endif
    @endif
</td>

