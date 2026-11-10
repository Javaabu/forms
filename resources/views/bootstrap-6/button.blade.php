<button
    {!! $attributes->class([
        $frameworkClasses()->button($color, $frameworkSize()),
        'animate-submit' => $animate,
        'cursor-progress' => $loading && $framework === 'onu',
    ]) !!}

    @if($type)
        type="{{ $type }}"
    @endif
    @if($loading)
        aria-busy="true"
        aria-disabled="true"
        data-loading="true"
    @endif
>
    @if($loading || $animate)
        <x-forms::icon name="loader-circle" :framework="$framework" class="forms-spinner animate-spin" :hidden="! $loading" data-slot="button-spinner" />
    @endif
    @if($startIcon)
        <x-forms::icon :name="$startIcon" :framework="$framework" data-icon="inline-start" />
    @endif
    {!! $slot !!}
    @if($endIcon)
        <x-forms::icon :name="$endIcon" :framework="$framework" data-icon="inline-end" />
    @endif
</button>
