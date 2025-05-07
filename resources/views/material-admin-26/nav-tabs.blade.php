<ul class="nav nav-tabs">
    @foreach($tabs as $item)
        <li class="nav-item">
            <a
            @class([
                'nav-link' => true,
                'active'   => ! empty($item['active']),
                'disabled' => ! empty($item['disabled']),
            ])
            href="{{ $item['url'] ?? '#' }}"
            >
                @if(isset($item['icon']))
                    <i class="{{ $item['icon'] }} mr-2"></i>
                @endif

                {{ $item['title'] }}
                @unless(empty($item['count']))
                    <span class="badge badge-primary d-inline-block py-1 px-2 ml-2 badge-pill">
                        {{ $item['count'] }}
                    </span>
                @endunless
            </a>
        </li>
    @endforeach
</ul>
