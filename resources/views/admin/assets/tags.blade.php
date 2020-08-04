@push('scripts')
    <script src="{{asset('gentellela/jquery.tagsinput.js')}}"></script>
    <script type="text/javascript">
        $('#tags').tagsInput({
            'autocomplete_url' : "{{ $route }}",
            'height':'100px',
            'width':'100%',
            'interactive': {{ $interactive }},
            'defaultText': '{{ $defaultText }}',
            'delimiter': "{{ $delimeter }}",   // Or a string with a single delimiter. Ex: ';'
            'removeWithBackspace' : true,
            'minChars' : 0,
            'maxChars' : 0, // if not provided there is no limit
            'placeholderColor' : '#666666'
        });
        @if(!$interactive)
            $('.tagsinput').find('a').remove();
        @endif
    </script>
@endpush
