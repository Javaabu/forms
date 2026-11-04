@if($items())
<div {{ $attributes->merge(['class' => 'alert theme-danger error-summary']) }} role="alert" tabindex="-1" data-forms-summary>
    <div class="flex-grow-1">
        <h4 class="alert-heading">{{ $heading() }}</h4>
        <ul class="mb-0">
            @foreach($items() as $item)
                @foreach($item['messages'] as $message)
                    <li><a href="#{{ $item['id'] }}" class="alert-link">@if($item['label']){{ $item['label'] }}: @endif{{ $message }}</a></li>
                @endforeach
            @endforeach
        </ul>
    </div>
</div>
@endif
