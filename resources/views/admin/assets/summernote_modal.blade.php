<script>
    // $('textarea.edit').summernote({
    //     height: 400,
    //     lang: 'sk-SK'
    // });
    var imageUploadUrlSum = "{{ route('image.save') }}";

    $('.summernote_modal').summernote({
        height: 400,
        lang: 'sk-SK'
    });

    // Initialize summernote plugin
    $('.summernote_modal').on('summernote.change', function (we, contents, $editable) {
        $(".input-info[data-langID='" + $(we.target).attr('data-langID') + "']").val(contents);
    });

    $('.summernote_modal').summernote({
        callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            }
        }
    });

    @foreach(\App\Models\Language\Language::all() as $lang)
    if ($(".input-info[data-langID='{{$lang->id}}']").val() != '') {
        $(".summernote_modal[data-langID='{{$lang->id}}']").summernote('code', $(".input-info[data-langID='{{$lang->id}}']").val());
    }
    @endforeach
</script>
