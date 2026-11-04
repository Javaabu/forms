@php($c = $frameworkClasses())
<nav {!! $attributes->merge(['class' => $c->classes('nav_tabs.nav-tabs')]) !!} data-slot="nav-tabs" data-variant="line" aria-label="{{ __('forms::strings.sections') }}">
    <ul class="nav {{ $c->classes('nav_tabs.list') }}">
        @foreach($tabs as $item)
            <li class="nav-item {{ $c->classes('nav_tabs.item') }}">
                <a
                    @class([
                        'nav-link',
                        $c->classes('nav_tabs.nav-tabs-item'),
                        'active' => ! empty($item['active']),
                        'disabled pointer-events-none opacity-50' => ! empty($item['disabled']),
                    ])
                    data-slot="nav-tabs-item"
                    href="{{ $item['url'] ?? '#' }}"
                    @if(! empty($item['active']))
                    data-active="true"
                    aria-current="page"
                    @endif
                    @if(! empty($item['disabled']))
                    aria-disabled="true"
                    @endif
                >
                    @if(isset($item['icon']))
                        <x-forms::icon :name="$item['icon']" :framework="$framework" />
                    @endif

                    <span>{{ $item['title'] }}</span>
                    @unless(empty($item['count']))
                        <span class="{{ $c->classes('nav_tabs.nav-tabs-count') }}" data-slot="nav-tabs-count">({{ $item['count'] }})</span>
                    @endunless
                </a>
            </li>
        @endforeach
    </ul>
</nav>
