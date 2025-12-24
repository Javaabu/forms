<x-forms::form :model="$model">
    <x-forms::select2 name="article" :options="$options" is-ajax name-field="title" />
</x-forms::form>