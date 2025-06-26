<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <x-forms::card>
                <div class="text-center">
                    <i class="{{ $icon }} main-icon mb-4"></i>
                    <p class="lead mb-4">
                        @if($title){{ $title }} <br/> @endif
                        {{ $message  }}
                    </p>
                    @if($showCreate)
                        @if($slot->isNotEmpty())
                            {{ $slot }}
                        @else
                            <x-forms::link-button class="btn-lg" :url="$createAction">
                                <i class="fal fa-plus me-2"></i> {{ __('Create New') }}
                            </x-forms::link-button>
                        @endif
                    @endif
                </div>
            </x-forms::card>
        </div>
    </div>
</div>
