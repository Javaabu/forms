@if($isAdminModel())
    {!! $value->admin_link !!}
@elseif($isAdminModelCollection())
    {!! $value->implode('admin_link', trans('forms::strings.table_array_separator')) !!}
@elseif($isStatusEnum())
    <x-forms::status :framework="$framework" :color="$value->getColor()" :label="$getEnumLabel()" />
@elseif($multiline)
    {!! nl2br(e($value ?: trans('forms::strings.blank'))) !!}
@elseif(is_array($value))
    {{ implode(trans('forms::strings.table_array_separator'), $value) }}
@else
    {{ $formatValue() }}
@endif
