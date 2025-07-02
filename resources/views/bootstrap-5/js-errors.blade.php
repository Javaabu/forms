<ul {!! $attributes->merge(['class' => 'invalid-feedback ' . $name . '-error']) !!}>
    {{ $slot }}
</ul>
