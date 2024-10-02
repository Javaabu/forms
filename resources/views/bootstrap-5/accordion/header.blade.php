<h2 {!! $attributes->merge(['class' => 'accordion-header']) !!}>
    <button
        class="accordion-button"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#{{ $target }}"
        aria-expanded="{{ $show ? 'true' : 'false' }}"
        aria-controls="{{ $target }}">
        @if($slot->isNotEmpty()){{ $slot }}@else{{ $title }}@endif
    </button>
</h2>

