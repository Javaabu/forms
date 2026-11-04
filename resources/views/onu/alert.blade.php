@php($c = $frameworkClasses())
@php($tone = $c->tone($type))
<div {{ $attributes->merge(['class' => 'alert ' . $c->alert($type)]) }} data-slot="callout" data-tone="{{ $tone }}" role="{{ in_array($tone, ['danger', 'warning']) ? 'alert' : 'status' }}">
    @if($icon)
        <x-forms::icon :name="$icon" :framework="$framework" />
    @endif

    @if(isset($heading) && $heading)
        <div class="{{ $c->classes("alert.{$tone}.alert-title") }}" data-slot="alert-title">{{ $heading }}</div>
    @endif

    <div class="{{ $c->classes("alert.{$tone}.alert-description") }}" data-slot="alert-description">
        {!! $slot !!}
    </div>

    @if($dismissible)
        <button type="button" class="{{ $c->classes("alert.{$tone}.button") }}" data-slot="button" data-variant="ghost" data-size="icon-xs" data-part="callout-dismiss" data-dismiss="alert" aria-label="{{ __('forms::strings.close') }}">
            <x-forms::icon name="x" :framework="$framework" />
        </button>
    @endif
</div>
