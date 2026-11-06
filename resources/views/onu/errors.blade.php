@if($messages())
<div {!! $attributes->merge(['class' => 'invalid-feedback ' . $frameworkClasses()->classes('field_invalid.field-errors')]) !!} data-slot="field-errors" aria-live="polite">
    @foreach($messages() as $message)
        <p class="{{ $frameworkClasses()->classes('field.error_line') }}">
            <x-forms::icon name="circle-alert" :framework="$framework" :class="$frameworkClasses()->classes('field.error_icon')" />
            <span>{{ $message }}</span>
        </p>
    @endforeach
</div>
@endif
