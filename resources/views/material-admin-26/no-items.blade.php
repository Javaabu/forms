<div class="no-items">
    <div class="card-body">
        <i class="{{ $icon }} main-icon mb-4"></i>
        <p class="lead mb-4">
            @if($title){{ $title }} <br/> @endif
            {{ $message  }}
        </p>
        @if($showCreate)
            @if($slot->isNotEmpty())
                {{ $slot }}
            @else
                <x-forms::link-button class="btn-lg btn--icon-text btn--raised" :url="$createAction">
                    <i class="zmdi zmdi-plus"></i> {{ __('Create New') }}
                </x-forms::link-button>
            @endif
        @endif
    </div>
</div>
