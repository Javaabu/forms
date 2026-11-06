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
    @if($sortable)
        <x-forms::icon :name="$sortIcon()" :framework="$framework" class="sort-icon ms-1 opacity-50" />
    @endif
</th>
