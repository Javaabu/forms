<x-forms::card :framework="$framework" {{ $attributes }}>
    {{ $slot }}

    <x-forms::hidden name="orderby" :framework="$framework" />

    <x-forms::hidden name="order" :framework="$framework" />
</x-forms::card>
