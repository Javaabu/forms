<x-forms::form :model="request()->all()">
    <x-forms::filter>
        <div class="row">
            <div class="col-md-3">
                <x-forms::text name="search" label="Search" :show-errors="false" />
            </div>
            <div class="col-md-3">
                <x-forms::select name="select" :options="['1' => 'Yes', '0' => 'No']" />
            </div>
            <div class="col-md-3">
                <x-forms::per-page />
            </div>
            <div class="col-md-3">
                <x-forms::filter-submit filter-url="/"/>
            </div>
        </div>
    </x-forms::filter>
</x-forms::form>
