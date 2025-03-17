<th
    @if ($colspan !== null)
        colspan="{{ $colspan }}"
    @endif

    @if ($sortable)
        data-sort-field="{{ $sortable }}"
    @endif

    {{ $attributes->merge([
        'class' => $sortable ? $addSortClass() : ''
    ]) }}
>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $label }}
    @endif
</th>
