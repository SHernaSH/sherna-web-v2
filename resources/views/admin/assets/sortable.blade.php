@push('styles')
    <style>
        body.dragging, body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            opacity: 0.5;
            z-index: 2000;
        }

        {{$selector}} tr {
            cursor: move; }
        {{$selector}} tr.placeholder {
            display: block;
            background: red;
            position: relative;
            margin: 0;
            padding: 0;
            border: none; }
        {{$selector}} tr.placeholder:before {
            content: "";
            position: absolute;
            width: 0;
            height: 0;
            border: 5px solid transparent;
            border-left-color: red;
            margin-top: -5px;
            left: -5px;
            border-right: none; }
    </style>
@endpush

@push('scripts')
    <script src="{{asset('js/jquery-sortable.js')}}"></script>
@endpush

@push('scripts')
    <script>
        // Sortable rows
        var oldIndex;
        $('{{$selector}}').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"/>',
            onDragStart: function ($item, container, _super) {
                oldIndex = $item.index();
            },
            onDrop: function  ($item, container, _super) {
                newIndex = $item.index();
                if(oldIndex != newIndex) {
                    var table = document.getElementById("{{$id}}");
                    var url = table.rows[newIndex + 1].cells[1].innerHTML;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        }
                    });
                    $.ajax({
                        url: "{{$route}}",
                        type: 'POST',
                        data: {
                            url: url,
                            oldIndex: oldIndex,
                            newIndex: newIndex
                        },
                        success: function () {
                            window.location.reload();
                        }
                        // dataType: 'html'
                    })
                }
                // alert(table.rows[newIndex+1].cells[1].innerHTML);
                // alert(newIndex);

                // if(newIndex != oldIndex) {
                //     $item.closest('table').find('tbody tr').each(function (i, row) {
                //         row = $(row);
                //         if(newIndex < oldIndex) {
                //             row.children().eq(newIndex).before(row.children()[oldIndex]);
                //         } else if (newIndex > oldIndex) {
                //             row.children().eq(newIndex).after(row.children()[oldIndex]);
                //         }
                //     });
                // }
                //
                // _super($item, container);
            }
        });
    </script>
@endpush
