@php($c = \Javaabu\Forms\Frameworks\Frameworks::get('onu'))
@if($paginator->count())
    <div class="flex items-center justify-between">
        <div class="text-sm text-muted-foreground">
            {{ trans_choice('forms::strings.pagination_showing', $paginator->total(), ['count' => $paginator->count(), 'total' => $paginator->total()]) }}
        </div>
    </div>
@endif

@if ($paginator->hasPages())
    <nav class="{{ $c->classes('pagination.pagination') }}" data-slot="pagination" role="navigation" aria-label="{{ __('forms::strings.pagination') }}">
        <ul class="pagination {{ $c->classes('pagination.pagination-content') }}" data-slot="pagination-content">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}" data-slot="pagination-item">
                @if ($paginator->onFirstPage())
                    <span class="page-link {{ $c->classes('pagination.previous') }} pointer-events-none opacity-50" aria-disabled="true" aria-label="{{ __('forms::strings.previous') }}">
                        <x-forms::icon name="chevron-left" framework="onu" class="rtl:rotate-180" />
                        <span class="hidden sm:block">{{ __('forms::strings.previous') }}</span>
                    </span>
                @else
                    <a class="page-link {{ $c->classes('pagination.previous') }}" data-slot="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('forms::strings.previous') }}">
                        <x-forms::icon name="chevron-left" framework="onu" class="rtl:rotate-180" />
                        <span class="hidden sm:block">{{ __('forms::strings.previous') }}</span>
                    </a>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" data-slot="pagination-item">
                        <span class="{{ $c->classes('pagination.pagination-ellipsis') }}" data-slot="pagination-ellipsis" aria-hidden="true">
                            <x-forms::icon name="ellipsis" framework="onu" />
                        </span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" data-slot="pagination-item">
                                <a class="page-link {{ $c->classes('pagination.link_active') }}" data-slot="pagination-link" data-active="true" aria-current="page" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item" data-slot="pagination-item">
                                <a class="page-link {{ $c->classes('pagination.link') }}" data-slot="pagination-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}" data-slot="pagination-item">
                @if ($paginator->hasMorePages())
                    <a class="page-link {{ $c->classes('pagination.next') }}" data-slot="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('forms::strings.next') }}">
                        <span class="hidden sm:block">{{ __('forms::strings.next') }}</span>
                        <x-forms::icon name="chevron-right" framework="onu" class="rtl:rotate-180" />
                    </a>
                @else
                    <span class="page-link {{ $c->classes('pagination.next') }} pointer-events-none opacity-50" aria-disabled="true" aria-label="{{ __('forms::strings.next') }}">
                        <span class="hidden sm:block">{{ __('forms::strings.next') }}</span>
                        <x-forms::icon name="chevron-right" framework="onu" class="rtl:rotate-180" />
                    </span>
                @endif
            </li>
        </ul>
    </nav>
@endif
