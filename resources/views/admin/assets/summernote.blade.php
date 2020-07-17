@push('styles')
    <link href="{{asset('summernote/summernote.css')}}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{asset('summernote/summernote.js')}}"></script>
    <script type="text/javascript">

        var imageUploadUrlSum = "{{ route('image.save') }}";

        $('.summernote').summernote({
            height: 400,
            lang: 'sk-SK'
        });

        // Initialize summernote plugin
        $('.summernote').on('summernote.change', function (we, contents, $editable) {
            $(".input-info[data-langID='" + $(we.target).attr('data-langID') + "']").val(contents);
        });

        $('.summernote').summernote({
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
            $(".summernote[data-langID='{{$lang->id}}']").summernote('code', $(".input-info[data-langID='{{$lang->id}}']").val());
        }
        @endforeach
    </script>
@endpush
