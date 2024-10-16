<div class="no-items">
    <div class="card-body">
        <i class="{{ $icon ?? 'zmdi zmdi-file' }} main-icon mb-4"></i>
        <p class="lead mb-4">
            {{ __('It\'s a bit lonely here.') }}<br/>
            {{ __('Let\'s create some new :model_type.', ['model_type' => $modelType ?? __('items') ]) }}
        </p>
        @can('create', $model)
            @if($slot->isNotEmpty())
                {{ $slot }}
            @else
                <a href="{{ $createAction ?? '#' }}" class="btn btn-lg btn-primary btn--icon-text btn--raised">
                    <i class="zmdi zmdi-plus"></i> {{ __('Create New') }}
                </a>
            @endif
        @endcan
    </div>
</div>
