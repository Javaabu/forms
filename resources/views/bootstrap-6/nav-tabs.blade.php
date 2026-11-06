<ul {!! $attributes->merge(['class' => 'nav nav-tabs']) !!}>
    @foreach($tabs as $item)
        <li class="nav-item">
            <a
                @class([
                    'nav-link' => true,
                    'active'   => ! empty($item['active']),
                    'disabled' => ! empty($item['disabled']),
                ])
                href="{{ $item['url'] ?? '#' }}"
                @if(! empty($item['active']))
                aria-current="page"
                @endif
            >
                @if(isset($item['icon']))
                    <x-forms::icon :name="$item['icon']" :framework="$framework" class="me-2" />
                @endif

                {{ $item['title'] }}
                @unless(empty($item['count']))
                    <span class="badge theme-primary ms-2">
                        {{ $item['count'] }}
                    </span>
                @endunless
            </a>
        </li>
    @endforeach
</ul>
