<div
    {!! $attributes->merge([
        'class' => 'card',
    ]) !!}
>
    {{ $image_top ?? '' }}

    @if(! empty($header))
        <x-forms::card.header :framework="$framework" :attributes="$header->attributes">
            {{ $header }}
        </x-forms::card.header>
    @endif

    <div class="card-body">
        @if(! empty($title))
            <x-forms::card.title :framework="$framework" :attributes="$title->attributes">
                {{ $title }}
            </x-forms::card.title>
        @endif

        @if(! empty($subtitle))
            <x-forms::card.subtitle :framework="$framework" :attributes="$subtitle->attributes">
                {{ $subtitle }}
            </x-forms::card.subtitle>
        @endif

        {!! $slot !!}
    </div>

    @if(! empty($footer))
        <x-forms::card.footer :framework="$framework" :attributes="$footer->attributes">
            {{ $footer }}
        </x-forms::card.footer>
    @endif
</div>
