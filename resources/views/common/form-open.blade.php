<form
    method="{{ $spoofMethod ? 'POST' : $method }}"

    @if($files)
        enctype="multipart/form-data"
    @endif

    {!! $attributes !!}
>
    @unless(in_array($method, ['HEAD', 'GET', 'OPTIONS']))
        @csrf
    @endunless

    @if($spoofMethod)
        @method($method)
    @endif
