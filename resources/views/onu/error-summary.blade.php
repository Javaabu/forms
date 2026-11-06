@if($items())
@php($c = $frameworkClasses())
<div {{ $attributes->merge(['class' => 'error-summary ' . $c->alert('danger')]) }} data-slot="callout" data-tone="danger" role="alert" tabindex="-1" data-forms-summary>
    <x-forms::icon name="circle-alert" :framework="$framework" />
    <div class="{{ $c->classes('alert.danger.alert-title') }}" data-slot="alert-title">{{ $heading() }}</div>
    <div class="{{ $c->classes('alert.danger.alert-description') }}" data-slot="alert-description">
        <ul class="list-disc ps-5">
            @foreach($items() as $item)
                @foreach($item['messages'] as $message)
                    <li><a href="#{{ $item['id'] }}">@if($item['label']){{ $item['label'] }}: @endif{{ $message }}</a></li>
                @endforeach
            @endforeach
        </ul>
    </div>
</div>
@endif
