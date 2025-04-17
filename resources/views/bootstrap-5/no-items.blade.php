<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <i class="{{ $icon }} main-icon mb-4"></i>
                    <p class="lead mb-4">
                        @if($title){{ $title }} <br/> @endif
                        {{ $message  }}
                    </p>
                    @if($showCreate)
                        @if($slot->isNotEmpty())
                            {{ $slot }}
                        @else
                            <a href="{{ $createAction }}" class="btn btn-lg btn-primary btn-icon-text btn-raised">
                                <i class="fal fa-plus me-2"></i> {{ __('Create New') }}
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
