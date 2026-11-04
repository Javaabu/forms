<form
    method="{{ $spoofMethod ? 'POST' : $method }}"
    @if($files)
        enctype="multipart/form-data"
    @endif

    @if($focusOnError)
        data-focus-on-error
    @endif

    {{ $attributes }}
>
    @unless(in_array($method, ['HEAD', 'GET', 'OPTIONS']))
        @csrf
    @endunless

    @if($spoofMethod)
        @method($method)
    @endif

    @if($summary)
        <x-forms::error-summary :title="$summaryTitle" :bag="$errorBag" :framework="$framework" />
    @endif

    {!! $slot !!}
</form>
