<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="md:col-6">
            <x-forms::card>
                <div class="text-center">
                    <x-forms::icon :name="$icon" :framework="$framework" class="main-icon mb-4 fs-4xl" />
                    <p class="fs-lg mb-4">
                        @if($title){{ $title }} <br/> @endif
                        {{ $message  }}
                    </p>
                    @if($showCreate)
                        @if($slot->isNotEmpty())
                            {{ $slot }}
                        @else
                            <x-forms::link-button class="btn-lg" :url="$createAction">
                                <x-forms::icon name="create" :framework="$framework" class="me-2" /> {{ __('forms::strings.create_new') }}
                            </x-forms::link-button>
                        @endif
                    @endif
                </div>
            </x-forms::card>
        </div>
    </div>
</div>
