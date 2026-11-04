<script src="{{ asset('vendors/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script type="text/javascript">
    tinymce.init({
        selector: '.wysiwyg',
        menubar: false,
        plugins: [
            'autolink',
            'link',
            'lists',
            'directionality',
            'code',
            'visualchars',
            'quickbars'
        ],
        toolbar: [
            'undo redo | styles bold italic | bullist numlist | alignleft aligncenter alignright alignjustify alignnone |' +
            ' link unlink | ltr rtl | outdent indent | code '
        ],
        quickbars_insert_toolbar: false
    });
</script>
