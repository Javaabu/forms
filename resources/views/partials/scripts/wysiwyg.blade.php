{{-- TinyMCE itself. resources/js/wysiwyg.ts (the forms::wysiwyg asset) initialises it on textarea.wysiwyg. --}}
<script src="{{ config('forms.wysiwyg.tinymce_url') ?: asset('vendors/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
