@php($c = $frameworkClasses())
@php($layout = $inline ? 'inline' : 'stacked')
<dl {!! $attributes->merge(['class' => $c->classes("description_list.{$layout}.description-list") . ' divide-y-0']) !!} data-slot="description-list" data-layout="{{ $layout }}">
    <div class="{{ $c->classes("description_list.{$layout}.description-list-item") }}" data-slot="description-list-item">
        @if($showLabel)
            <dt class="{{ $c->classes("description_list.{$layout}.description-list-label") }} {{ $inline ? $inlineEntryLabelClass : '' }}" data-slot="description-list-label">{{ $label ?: $label() }}</dt>
        @endif

        <dd class="{{ $c->classes("description_list.{$layout}.description-list-value") }} {{ $inline ? $inlineEntryClass : '' }}" data-slot="description-list-value">
            <div class="min-w-0 flex-1">
            @if($slot->isNotEmpty())
                {{ $slot }}
            @elseif($isAdminModel())
                {!! $value->admin_link !!}
            @elseif($isAdminModelCollection())
                {!! $value->implode('admin_link', trans('forms::strings.table_array_separator')) !!}
            @else
                @if($isStatusEnum())
                    <x-forms::status :framework="$framework" :color="$value->getColor()" :label="$getEnumLabel()" />
                @elseif($isNativeEnum())
                    {{ $getEnumLabel() }}
                @elseif($multiline)
                    {!! nl2br(e($value ?: trans('forms::strings.blank'))) !!}
                @elseif(is_array($value))
                    <ul class="list-disc ps-5">
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
            </div>
        </dd>
    </div>
</dl>
