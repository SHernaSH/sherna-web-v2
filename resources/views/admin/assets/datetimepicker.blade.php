@push('styles')
    <link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{asset('assets_admin/js/datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>

    @include('assets.datepicker_locale')

    <script type="text/javascript">
        var edit = {{ \App\Models\Settings\Setting::where('name', 'Time for Edit')->first()->value}};
        var formDate = $(".form_datetime").datetimepicker({
            language      : '{{Session::get('lang')}}',
            format        : "dd.mm.yyyy hh:ii",
            autoclose     : true,
            startDate     : moment().add(edit + 1, 'm').format('YYYY-MM-DD HH:mm'),
            endDate       : moment().add(reservationarea, 'd').format('YYYY-MM-DD HH:mm'),
            todayBtn      : true,
            todayHighlight: false,
            fontAwesome   : true,
            pickerPosition: "bottom-left",
            minuteStep    : 15,

        });


        var toDate = $(".to_datetime").datetimepicker({
            language      : '{{Session::get('lang')}}',
            format        : "dd.mm.yyyy hh:ii",
            autoclose     : true,
            startDate     : moment().add(edit * 2, 'm').format('YYYY-MM-DD HH:mm'),
            todayBtn      : true,
            todayHighlight: false,
            fontAwesome   : true,
            pickerPosition: "bottom-right",
            minuteStep    : 15
        });
    </script>
@endpush
