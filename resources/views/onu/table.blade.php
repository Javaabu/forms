@php($c = $frameworkClasses())
<div {!! $attributes->merge(['class' => 'table-responsive ' . $c->classes('table.table-container')]) !!} data-slot="table-container">

    @if(empty($noBulk))
        @if(isset($bulkForm) && $bulkForm->isNotEmpty())
            <x-forms::form :action="$bulkForm->attributes->get('action')" >
                <div class="p-4">
                    {{ $bulkForm }}
                </div>
        @endif
    @endif

    {{ $beforeTable ?? '' }}

    <div class="mt-0">
        @if(empty($noCheckbox))
            <div class="p-4 lg:hidden bg-muted">
                <div class="{{ $c->classes('choice.checkbox-field') }}">
                    <input id="{{ ($model ?? '').'-select-all-resp' }}" data-all="{{ $model ?? '' }}" value="1" class="{{ $c->classes('checkbox.native') }} forms-checkbox" type="checkbox" />
                    <label for="{{ ($model ?? '').'-select-all-resp' }}" class="{{ $c->classes('choice.label') }} font-semibold">{{ __('forms::strings.select_all') }}</label>
                </div>
            </div>
        @endif
        <table class="table {{ $c->classes('table.table') }} {{ $table_class ?? '' }}{{ $striped ? ' table-striped [&_tbody_tr:nth-child(odd)]:bg-muted/40' : '' }}" data-slot="table" data-form-sortable="#{{ $filter_id ?? 'filter' }}">
            <thead class="{{ $c->classes('table.table-header') }}" data-slot="table-header">
                {{ $beforeHeaders ?? '' }}
                <tr class="{{ $c->classes('table.table-row') }}" data-slot="table-row">
                    @if(empty($noCheckbox))
                        <th class="td-checkbox {{ $c->classes('table.table-head') }} w-px" data-slot="table-head">
                            <input id="{{ ($model ?? '').'-select-all' }}" data-all="{{ $model ?? '' }}" value="1" class="{{ $c->classes('checkbox.native') }} forms-checkbox" type="checkbox" aria-label="{{ __('forms::strings.select_all') }}" />
                        </th>
                    @endif
                    {{ $headers ?? '' }}
                </tr>
                {{ $afterHeaders ?? '' }}
            </thead>

            @if(empty($tbodyOpen))
            <tbody class="{{ $c->classes('table.table-body') }}" data-slot="table-body">
            @else
            {{ $tbodyOpen }}
            @endif

                {{ $rows ?? '' }}

            </tbody>
            {{ $afterTbody ?? '' }}
        </table>
    </div>

    @if(empty($noBulk))
        @if(isset($bulkForm) && $bulkForm->isNotEmpty())
            </x-forms::form>
        @endif
    @endif
</div>

@if(empty($no_pagination))
    {{ $pagination ?? '' }}
@endif
