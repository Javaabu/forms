<li class="nav-item" role="presentation">
    @if($isTab)
        <button
            type="button"
            data-bs-toggle="tab"
            role="tab"
            id="{{ $id() }}"
            data-bs-target="#{{ $target }}"
            aria-controls="{{ $target }}"
            aria-selected="{{ $active ? 'true' : 'false' }}"
            {!! $attributes->class([
                'nav-link',
                'active' => $active,
        ]) !!}
            @if($disabled)
                disabled
            @endif
        >@if($slot->isNotEmpty()){{ $slot }}@else{{ $title }}@endif</button>
    @else
        <a href="{{ $url }}"
            {!! $attributes->class([
            'nav-link',
            'active' => $active,
            'disabled' => $disabled
        ]) !!}>@if($slot->isNotEmpty()){{ $slot }}@else{{ $title }}@endif</a>
    @endif
</li>
