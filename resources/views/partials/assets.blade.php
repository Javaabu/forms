{{-- Asset seam: components call this with the assets they need. See docs/advanced-usage/assets.md. --}}
@foreach($assets as $asset)
    @if(view()->exists("forms::partials.scripts.{$asset}"))
        @pushonce(config('forms.scripts_stack'), "forms-{$asset}")
            @include("forms::partials.scripts.{$asset}")
        @endpushonce
    @endif
@endforeach
