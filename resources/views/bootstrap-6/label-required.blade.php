@if($text)
    <span {!! $attributes->merge(['class' => 'required fg-danger', 'aria-hidden' => 'true']) !!}>{{ $text }}</span>
@endif
