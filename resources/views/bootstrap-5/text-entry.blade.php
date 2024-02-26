<dl {!! $attributes->merge(['class' => 'mb-1'.($inline ? ' row' : '')]) !!}>
    @if($label)
        <dt
            @if($inline)
            class="col-sm-6 col-md-4"
            @endif
        >{{ $label }}</dt>
    @endif

    <dd
        @if($inline)
        class="col-sm-6 col-md-8"
        @endif
    >
        @if($isAdminModel())
            {!! $value->admin_link !!}
        @else
            {{ $value ?: $slot }}
        @endif
    </dd>
</dl>