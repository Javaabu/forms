@php
    $classes = 'alert alert-' . $type;

    if ($dismissible) {
        $classes .= ' alert-dismissible fade show';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    @if($icon)
        <div class="d-flex align-items-start">
            <i class="{{ $icon }} flex-shrink-0 me-2" aria-hidden="true"></i>
            <div class="flex-grow-1">
                @if(isset($heading) && $heading)
                    <h4 class="alert-heading">{{ $heading }}</h4>
                @endisset

                {!! $slot !!}
            </div>
        </div>
    @else
        @if(isset($heading) && $heading)
            <h4 class="alert-heading">{{ $heading }}</h4>
        @endisset

        {!! $slot !!}
    @endif

    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
