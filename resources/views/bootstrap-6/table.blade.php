<div {!! $attributes->merge(['class' => 'table-responsive']) !!}>

    @if(empty($no_bulk) && isset($bulkForm) && $bulkForm->isNotEmpty())
        <x-forms::form :action="$bulkForm->attributes->get('action')" :method="$bulkForm->attributes->get('method', 'POST')" :framework="$framework">
            <div class="p-4">
                {{ $bulkForm }}
            </div>

            @include('forms::bootstrap-6.table.table')
        </x-forms::form>
    @else
        @include('forms::bootstrap-6.table.table')
    @endif
</div>

@if(empty($no_pagination))
    {{ $pagination ?? '' }}
@endif
