@if($showLink)
<a {{ $attributes->merge([
    'href' => $url
]) }}>
@endif
    @if($slot->isNotEmpty())
        {{ $slot }}
    @elseif($isAdminModel())
        {{ $value->admin_link_name }}
    @else
        @if($isStatusEnum())
            <x-forms::status :framework="$framework" :color="$value->getColor()" :label="$getEnumLabel()" />
        @elseif($multiline)
            {!! nl2br(e($value ?: trans('forms::strings.blank'))) !!}
        @elseif(is_array($value))
            {{ implode(trans('forms::strings.table_array_separator'), $value) }}
        @else
            {{ $formatValue() }}
        @endif
    @endif
@if($showLink)
</a>
@endif

