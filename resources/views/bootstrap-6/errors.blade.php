@error($name, $bag)
<div {!! $attributes->merge(['class' => 'invalid-feedback d-block']) !!}>
    {{ $message }}
</div>
@enderror
