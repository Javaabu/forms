{{-- The table itself; table.blade.php puts it inside the bulk form when there is one. --}}
    {{ $beforeTable ?? '' }}

    <div class="mt-0">
        @if(empty($noCheckbox))
            <div class="p-4 lg:d-none bg-2">
                <div class="form-field">
                    <input id="{{ ($model ?? '').'-select-all-resp' }}" data-all="{{ $model ?? '' }}" value="1" class="check" type="checkbox" />
                    <label for="{{ ($model ?? '').'-select-all-resp' }}" class="fw-semibold">{{ __('forms::strings.select_all') }}</label>
                </div>
            </div>
        @endif
        <table class="table mt-0 {{ $table_class ?? '' }}{{ $striped ? ' table-striped' : '' }}" data-form-sortable="#{{ $filter_id ?? 'filter' }}">
            <thead>
                {{ $beforeHeaders ?? '' }}
                <tr>
                    @if(empty($noCheckbox))
                        <th class="td-checkbox">
                            <input id="{{ ($model ?? '').'-select-all' }}" data-all="{{ $model ?? '' }}" value="1" class="check" type="checkbox" aria-label="{{ __('forms::strings.select_all') }}" />
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
            {{ $afterTbody ?? '' }}
        </table>
    </div>
