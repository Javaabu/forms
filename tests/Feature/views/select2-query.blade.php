@php
    use Javaabu\Forms\Tests\Feature\Country;
@endphp

<x-form :model="$address">
    <x-form-select2 name="country" :options="Country::query()" />

    <x-form-submit>Submit</x-form-submit>
</x-form>