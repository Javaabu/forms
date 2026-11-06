<ul {!! $attributes->merge(['class' => 'invalid-feedback list-unstyled ' . $name . '-error']) !!}>
    {{ $slot }}
</ul>
