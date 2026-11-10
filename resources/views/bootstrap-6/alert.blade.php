<div {{ $attributes->merge(['class' => $frameworkClasses()->alert($type)]) }} role="alert">
    @if($icon)
        <x-forms::icon :name="$icon" :framework="$framework" class="flex-shrink-0" />
    @endif

    <div class="flex-grow-1">
        @if(isset($heading) && $heading)
            <h4 class="alert-heading">{{ $heading }}</h4>
        @endif

        {!! $slot !!}
    </div>

    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('forms::strings.close') }}"></button>
    @endif
</div>
