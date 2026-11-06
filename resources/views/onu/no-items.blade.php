@php($c = $frameworkClasses())
<div {!! $attributes->merge(['class' => $c->classes('empty.empty') . ' border']) !!} data-slot="empty">
    <div class="{{ $c->classes('empty.empty-header') }}" data-slot="empty-header">
        <div class="{{ $c->classes('empty.empty-icon') }}" data-slot="empty-icon" data-variant="icon">
            <x-forms::icon :name="$icon" :framework="$framework" class="main-icon" />
        </div>
        @if($title)
            <div class="{{ $c->classes('empty.empty-title') }}" data-slot="empty-title">{{ $title }}</div>
        @endif
        <div class="{{ $c->classes('empty.empty-description') }}" data-slot="empty-description">{{ $message }}</div>
    </div>
    @if($showCreate)
        <div class="{{ $c->classes('empty.empty-content') }}" data-slot="empty-content">
            @if($slot->isNotEmpty())
                {{ $slot }}
            @else
                <x-forms::link-button :url="$createAction" :framework="$framework">
                    <x-forms::icon name="create" :framework="$framework" /> {{ __('forms::strings.create_new') }}
                </x-forms::link-button>
            @endif
        </div>
    @endif
</div>
