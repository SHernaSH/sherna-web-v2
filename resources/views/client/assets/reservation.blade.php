@push('scripts')
    <script src="{{asset('gentellela/fullcalendar.js')}}"></script>
    <script src="{{asset('gentellela/fullcalendar-locale.js')}}"></script>

    <script>
        var myReservationColor           = ""//'{{config('calendar.my-reservation.color')}}';
        var myReservationBorderColor     = '{{config('calendar.my-reservation.border-color')}}';
        var myReservationBackgroundColor = '{{config('calendar.my-reservation.background-color')}}';
        var admin                        = {{(\Auth::check() && \Auth::user()->isAdmin()) ? 1 : 0}};
        var format = "DD.MM.YYYY HH:mm";
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            saveReservation();
            initCalendar();
            initOnChangeLocation();
            showCalenderIfOpened();
        });

        function createEvent(start, end) {
            $('.form_datetime').val(start.format(format));
            $('.to_datetime').val(end.format(format));
            $('#location_id').val($('[name="location"]:checked').val());
            $('#note').val('');
            $('#visitors_count').val('1');
            $('#createReservationModal').modal('show');

        }

        function controlEventTimes(start, end, isResize = false) {
            // if (Math.abs(start.diff(end, 'days')) !== 0) {
            //     $('#calendar').fullCalendar('unselect');
            //     alert('Make 2 separate reservations for this operation.');
            //     return false;
            // }
            var max = isResize ? maxeventduration * 2 : maxeventduration;
            if (Math.abs(start.diff(end, 'hours')) > max) {
                $('#calendar').fullCalendar('unselect');
                App.helpers.alert.info('Maximum duration exceeded', 'Max duration of reservation can be ' + maxeventduration + ' hours.');
                return false;
            }
            return true;
        }
        function reRenderCallendar() {
            $('#calendar-loader').removeClass('hidden');
            // $('#calendar').addClass('hidden');
            $('#calendar').fullCalendar('removeEvents');
            $('#calendar').fullCalendar('refetchEvents');
            setTimeout(function () {
                $('#calendar-loader').addClass('hidden');
                // $('#calendar').removeClass('hidden');
            },1000);
        }


        function update(event, revertFunc) {
            $("#updateReservationForm").attr("action", "{{ route('reservation.index') }}/" + event.id);
            $('#u_from_date').val(event.start.format(format));
            $('#u_to_date').val(event.end.format(format));
            $('#u_visitors_count').val(event.visitors_count);
            $('#u_note').val(event.note);
            $('#u_location_id').val(event.location_id);
        }



        function updateEvent(event, revertFunc, isResize = false) {
            var start = event.start;
            var end   = event.end;

            var correct = controlEventTimes(start, end, isResize);
            if (!correct) {
                revertFunc();
                return;
            }
            App.helpers.alert.confirm(App.trans('sure-update'), App.trans('sure-update-text'), 'warning', function () {
                update(event);
                $("#updateReservationBtn").click();
            }, function () {
                revertFunc();
            })
        }


        function saveReservation() {

            $('#saveReservation').unbind();
            $('#saveReservation').bind('click', function (ev) {

                var valid = true;
                if ($('#from_date').val() == '') {
                    App.helpers.alert.info(App.trans('not-filled'), App.trans('fill-start-date'), 'danger');
                    valid = false;
                }
                else if ($('#to_date').val() == '') {
                    App.helpers.alert.info(App.trans('not-filled'), App.trans('fill-to-date'), 'danger');
                    valid = false;
                }
                if (!valid) {
                    ev.preventDefault();
                    return;
                }


            });
        }

        function initCalendar() {
            var canCreate=  {{Auth::check() && (Auth::user()->isAdmin() || !Auth::user()->banned && Auth::user()->reservations()->futureActiveReservations()->count() == 0) ? 'true' : 'false' }};
            var canEditDuration =  {{Auth::check() && (Auth::user()->isAdmin() || !Auth::user()->banned)  ? 'true' : 'false' }};
            var calendar = $('#calendar').fullCalendar({
                header         : {
                    left  : 'prev,next',
                    center: 'title',
                    right : ''
                },
                views          : {
                    agendaWeek: {
                        slotDuration: '00:15:00'
                    }
                },
                firstDay       : 1,
                nowIndicator   : true,
                allDaySlot     : false,
                timeFormat     : 'H:mm',
                slotLabelFormat: "H:mm",
                columnFormat   : 'ddd D.M.',
                locale         : '{{Session::get('lang') == 'cz' ? 'cs' : Session::get('lang') }}',
                titleFormat    : 'D. MMMM YYYY',
                defaultDate    : moment(new Date()).format('YYYY-MM-DD'),
                defaultView    : 'agendaWeek',
                editable       : canCreate,
                eventDurationEditable : canEditDuration,
                displayEventTime: true,
                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                    if (event.own) {
                        // event.textColor       = myReservationColor;
                        // event.borderColor     = myReservationBorderColor;
                        // event.backgroundColor = myReservationBackgroundColor;
                        element.css('background-color', myReservationBackgroundColor)
                        element.css('border-color', myReservationBorderColor)
                        element.css('text-color', myReservationColor)
                    }
                },
                selectable: canCreate,
                selectHelper: true,
                select         : function (start, end) {

                    start = start.clone().subtract(2, 'h');
                    end = end.clone().subtract(2, 'h');
                    var correct = controlEventTimes(start, end);
                    if (!correct) {
                        return;
                    }

                    var now               = moment();
                    var future_date_today = moment(now).add(durationforedit, 'm');
                    var future_date       = moment(now).add(reservationarea, 'days');

                    if ((admin && start.isAfter(now.add(10, 'm').format('YYYY-MM-DD HH:mm'))) || start.isAfter(future_date_today.format('YYYY-MM-DD HH:mm')) && end.isBefore(future_date.format('YYYY-MM-DD'))) {
                        createEvent(start, end);
                    }
                    else {
                        $('#calendar').fullCalendar('unselect');
                        App.helpers.alert.info("You cannot reserve here", "This date/time is not opened for reservations.");
                    }
                },
                eventLimit     : true, // allow "more" link when too many events
                eventOverlap   : false,
                eventSources   : [
                    {
                        url   : '{{ route('getReservations') }}',
                        type   : 'POST',
                        data   : function () { // a function that returns an object
                            return {
                                location: $('[name="location"]:checked').val()
                            };
                        },
                        error  : function () {
                            App.helpers.alert.info(App.trans('modalProblemOnServer.title'), App.trans('modalProblemOnServer.text'));
                        },
                        overlap: false
                    }
                ],
                eventClick     : function (event) {
                    $('#updateReservation').addClass('hidden');
                    $('#updateReservation').unbind();
                    $('#deleteReservation').addClass('hidden');
                    $('#deleteReservation').unbind();
                        $('#showReservationModalLabel').text(event.title);
                        $('#start').text(event.start.format("DD.MM.YYYY - HH:mm"));
                        $('#end').text(event.end.format("DD.MM.YYYY - HH:mm"));

                        if (event.edit) {
                            $('#deleteReservation').removeClass('hidden');
                            $("#deleteReservationForm").attr("action", "{{ route('reservation.index') }}/" + event.id);
                            $('#deleteReservation').unbind();
                            $('#deleteReservation').bind('click', function (ev) {
                                ev.preventDefault();
                                App.helpers.alert.confirm(App.trans('sure-delete'), App.trans('sure-delete-text'), 'warning', function () {
                                    $("#deleteReservationForm").submit();
                                })
                            });

                            //TODO ADD CHECK IF SHOULD BE EDITABLE, is in past, etc
                            $('#updateReservation').removeClass('hidden');
                            $('#updateReservation').unbind();
                            $('#updateReservation').bind('click', function (ev) {
                                update(event, null);
                                $('#updateReservationModal').modal('show');
                            });
                        }
                    $('#showReservationModal').modal('show');

                }
                ,
                eventResize    : function (event, delta, revertFunc) {
                    updateEvent(event, revertFunc, true);
                },
                eventDrop      : function (event, delta, revertFunc) {
                    updateEvent(event, revertFunc);
                },
                eventAllow     : function (dropLocation, draggedEvent) {
                    var now               = moment();
                    var future_date_today = moment(now).add(durationforedit, 'm');
                    var future_date       = moment(now).add(reservationarea, 'days');

                    //gmt fix dragged event and drop is two hours ahead caused by localization
                    var dropStart = dropLocation.start;
                    dropStart     = dropStart.subtract(2, 'h');
                    var dropEnd = dropLocation.end;
                    dropEnd     = dropEnd.subtract(2, 'h');
                    var eventStart = draggedEvent.start.clone().subtract(2, 'h');
                    var eventEnd = draggedEvent.end.clone().subtract(2, 'h');

                    var resize = eventStart.isSame(dropStart);

                    if(eventStart.isBefore(now) && !resize) {
                        return false;
                    }


                    if(!resize) {
                        return (admin && dropStart.isAfter(now.add(10, 'm').format('YYYY-MM-DD HH:mm')))
                            || dropStart.isAfter(future_date_today.format('YYYY-MM-DD HH:mm'))
                            && dropStart.isBefore(future_date.format('YYYY-MM-DD'));
                    }
                    var allowedTimeUpdate = eventEnd.clone().subtract(durationforedit, 'm');
                    var isInTimeToProlong = now.isAfter(allowedTimeUpdate) || now.isBefore(eventStart);
                    var isInPast = eventEnd.isBefore(now);
                    return !isInPast && (admin || isInTimeToProlong) && dropEnd.isAfter(
                        now.add('{{App\Models\Settings\Setting::where('name', 'Time for edit')->first()->value}}', 'm')
                            .format('YYYY-MM-DD HH:mm'));
                }
            });

            $('.fc-button').addClass('btn btn-primary').removeClass('fc-button').removeClass('fc-button fc-state-default');
            $('.fc-button-group').addClass('btn-group').removeClass('fc-button-group').attr('data-toggle', 'buttons');
        }

        function initOnChangeLocation() {
            $(document).on('change', '[name="location"]', function (ev) {
                $('#calendarContainer').css('visibility', 'visible');
                reRenderCallendar();
            });
        }

        function showCalenderIfOpened() {
            if($('[name="location"]:checked').size() > 0)
                $('#calendarContainer').css('visibility', 'visible');

        }
    </script>

@endpush
@include('client.assets.datepicker')

@push('styles')
    <link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet"
          media="print">
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
@endpush
