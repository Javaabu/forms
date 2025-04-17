<x-forms::form :model="$post">
    <x-forms::select2 name="author" :options="$options" formGroupClass='custom-class'/>
    <x-forms::submit>Submit</x-forms::submit>
</x-forms::form>
