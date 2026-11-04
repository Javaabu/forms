<a
    {!! $attributes->merge([
        'class' => $frameworkClasses()->button($color, $frameworkSize()) . ($disabled ? ' disabled pointer-events-none opacity-50' : ''),
    ]) !!}

    @if($url && ! $disabled)
        href="{{ $url }}"
    @endif
    @if($disabled)
        aria-disabled="true"
        role="link"
    @endif
>
    @if($startIcon)
        <x-forms::icon :name="$startIcon" :framework="$framework" data-icon="inline-start" />
    @endif
    {!! $slot !!}
    @if($endIcon)
        <x-forms::icon :name="$endIcon" :framework="$framework" data-icon="inline-end" />
    @endif
</a>
