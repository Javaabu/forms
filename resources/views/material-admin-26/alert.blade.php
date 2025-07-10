@php
    $classes = 'alert alert-' . $type;

    if ($dismissible) {
        $classes .= ' alert-dismissible fade show';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    @if($icon)
        <div class="d-flex align-items-baseline">
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
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    @endif
</div>
