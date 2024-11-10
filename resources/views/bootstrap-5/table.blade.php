<div {!! $attributes->merge(['class' => 'table-responsive']) !!}>

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
            <div class="p-4 hidden-lg-up bg-light">
                <div class="checkbox">
                    <input id="{{ ($model ?? '').'-select-all-resp' }}" data-all="{{ $model ?? '' }}" value="1" class="form-check-input" type="checkbox" />
                    <label for="{{ ($model ?? '').'-select-all-resp' }}" class="form-check-label font-weight-bold">{{ __('Select All') }}</label>
                </div>
            </div>
        @endif
        <table class="table mt-0 {{ $table_class ?? '' }}{{ $striped ? ' table-striped' : '' }}" data-form-sortable="#{{ $filter_id ?? 'filter' }}">
            <thead class="thead-default">
                {{ $beforeHeaders ?? '' }}
                <tr>
                    @if(empty($noCheckbox))
                        <th class="td-checkbox">
                            <div class="checkbox">
                                <input id="{{ ($model ?? '').'-select-all' }}" data-all="{{ $model ?? '' }}" value="1" class="form-check-input" type="checkbox" />
                                <label for="{{ ($model ?? '').'-select-all' }}" class="form-check-label"></label>
                            </div>
                        </th>
                    @endif
                    {{ $headers ?? '' }}
                </tr>
                {{ $afterHeaders ?? '' }}
            </thead>

            @if(empty($tbodyOpen))
            <tbody>
            @else
            {{ $tbodyOpen }}
            @endif

                {{ $rows ?? '' }}

            </tbody>
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
