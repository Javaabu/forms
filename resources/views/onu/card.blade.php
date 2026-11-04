<div
    {!! $attributes->merge([
        'class' => $frameworkClasses()->classes('card.card'),
    ]) !!}
    data-slot="card"
>
    {{ $image_top ?? '' }}

    @if(! empty($header) || ! empty($title) || ! empty($subtitle))
    <x-forms::card.header :framework="$framework" :attributes="isset($header) ? $header->attributes : new \Illuminate\View\ComponentAttributeBag()">
        @if(! empty($header))
            {{ $header }}
        @endif

        @if(! empty($title))
            <x-forms::card.title :framework="$framework">
                {{ $title }}
            </x-forms::card.title>
        @endif

        @if(! empty($subtitle))
            <x-forms::card.subtitle :framework="$framework" :attributes="$subtitle->attributes">
                {{ $subtitle }}
            </x-forms::card.subtitle>
        @endif
    </x-forms::card.header>
    @endif

    <div class="{{ $frameworkClasses()->classes('card.card-content') }}" data-slot="card-content">
        {!! $slot !!}
    </div>

    @if(! empty($footer))
        <x-forms::card.footer :framework="$framework" :attributes="$footer->attributes">
            {{ $footer }}
        </x-forms::card.footer>
    @endif
</div>
