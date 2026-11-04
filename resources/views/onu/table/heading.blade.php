<th
    @if ($colspan !== null)
        colspan="{{ $colspan }}"
    @endif

    @if ($sortable)
        data-sort-field="{{ $sortable }}"
    @endif

    {{ $attributes->merge([
        'class' => $frameworkClasses()->classes('table.table-head') . ($sortable ? ' ' . $addSortClass() : '')
    ]) }}
    data-slot="table-head"
>
    @if($slot->isNotEmpty())
        {{ $slot }}
    @else
        {{ $label }}
    @endif
</th>
