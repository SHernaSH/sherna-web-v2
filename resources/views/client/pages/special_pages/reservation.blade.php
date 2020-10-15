@include('client.assets.reservation')
    <div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <div class="row">
                @foreach(\App\Models\Locations\Location::get() as $location)
                    <div class="col-md-6 col-xs-6 text-center">
                        <p class="location_radio">
                                <input id="location{{$location->id}}" type="radio" name="location"
                                       value="{{$location->id}}"
                                       autocomplete="off" {{$location->status->opened ?'checked':'disabled'}}>
                                <label for="location{{$location->id}}">
                                    <i class="location-state {{$location->status->opened ?'opened':'closed'}}">{{$location->status->name}}</i>
                                    <i class="fa fa-building"></i> {{$location->name}}
                                </label>
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
            @if(Auth::check())
                @if(!Auth::user()->canCreate())
                    <span class="text-danger"><b>{{trans('general.future_reservations')}}</b></span>
                @elseif(Auth::user()->banned)
                    <span class="text-danger"><b>{{trans('general.ban')}}</b></span>
                @else
                    <a href="#" data-toggle="modal" data-target="#createReservationModal"
                       class="btn btn-default">{{trans('reservation-modal.title')}}</a>
                @endif
            @else
                <span class="text-danger"><b>{{ trans('reservations.login') }}</b></span>
{{--                <a href="{{ route('login') }}"--}}
{{--                   class="btn btn-default">{{trans('reservation-modal.title')}}</a>--}}
            @endif
        </div>

    </div>
    <hr>
</div>

<div class="container hidden" id="calendar-loader">
    <div class="col-md-12 text-center">
        <span class="fa fa-spinner fa-spin fa-2x"></span>
    </div>
</div>

<div class="container">
    <div class="row">
        <div id="calendarContainer" class="col-md-12" style="visibility: hidden">
            <div id="calendar" ></div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="createReservationModal" tabindex="-1" role="dialog"
     aria-labelledby="createReservationModalLabel">
    <div class="modal-dialog" role="document">
        <form id="createModalForm" action="{{ route('reservation.store') }}" class="" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="createReservationModalLabel">{{trans('reservation-modal.title')}}</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="from_date"
                                           class="control-label">{{trans('reservation-modal.from_date')}}
                                        <span
                                            class="text-danger">*</span></label>
                                    <input name="from_date" class="form-control form_datetime"
                                           id="from_date" autocomplete="off"
                                           type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="to_date"
                                           class="control-label">{{trans('reservation-modal.to_date')}}
                                        <span
                                            class="text-danger">*</span></label>
                                    <input name="to_date" class="form-control to_datetime"
                                           id="to_date" autocomplete="off"
                                           type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location_id"
                                       class="control-label">{{trans('reservations.location')}}</label>
                                <select name="location_id" id="location_id" class="form-control">
                                    @foreach(\App\Models\Locations\Location::opened()->get() as $location)
                                        <option value="{{$location->id}}" {{old('location')==$location->id ? 'selected':''}}>{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="visitors_count"
                                       class="control-label">{{trans('reservation-modal.visitors_count')}}</label>
                                <input type="number" min="1" class="form-control" name="visitors_count"
                                       id="visitors_count">
                            </div>

                            <div class="form-group">
                                <label for="vr"
                                       class="control-label">VR</label>
                                <input type="checkbox" class="form-control js-switch" name="vr"
                                       id="vr">
                            </div>

                            <div class="form-group">
                                <label for="note"
                                       class="control-label">{{trans('reservation-modal.note')}}</label>
                                <textarea class="form-control" id="note" name="note"
                                          rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <b class="text-danger">
                                    {{trans('reservation-modal.required_order')}}
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"
                            data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
                    <button name="submit" id="saveReservation"
                            class="btn btn-default">{{trans('reservation-modal.save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Update Modal -->
<div class="modal fade" id="updateReservationModal" tabindex="-1" role="dialog"
     aria-labelledby="updateReservationModalLabel">
    <div class="modal-dialog" role="document">
        <form id="updateReservationForm" class="" method="post">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="updateReservationModalLabel">{{trans('reservation-modal.title')}}</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" name="location_id" id="u_location_id">
                                    <label for="u_from_date"
                                           class="control-label">{{trans('reservation-modal.from_date')}}
                                        <span
                                            class="text-danger">*</span></label>
                                    <input name="from_date" class="form-control form_datetime"
                                           id="u_from_date" autocomplete="off"
                                           type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="u_to_date"
                                           class="control-label">{{trans('reservation-modal.to_date')}}
                                        <span
                                            class="text-danger">*</span></label>
                                    <input name="to_date" class="form-control to_datetime"
                                           id="u_to_date" autocomplete="off"
                                           type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="u_visitors_count"
                                       class="control-label">{{trans('reservation-modal.visitors_count')}}</label>
                                <input type="number" min="1" class="form-control" name="visitors_count"
                                       id="u_visitors_count">
                            </div>

                            <div class="form-group">
                                <label for="u_vr"
                                       class="control-label">VR</label>
                                <input type="checkbox" class="form-control js-switch" name="vr"
                                       id="u_vr">
                            </div>

                            <div class="form-group">
                                <label for="u_note"
                                       class="control-label">{{trans('reservation-modal.note')}}</label>
                                <textarea class="form-control" id="u_note" name="note"
                                          rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <b class="text-danger">
                                    {{trans('reservation-modal.required_order')}}
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"
                            data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
                    <button name="submit" id="updateReservationBtn"
                            class="btn btn-default">{{trans('reservation-modal.save')}}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="showReservationModal" tabindex="-1" role="dialog"
     aria-labelledby="showReservationModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="showReservationModalLabel"></h4>
            </div>
            <div class="modal-body">

                <p>
                    <strong>{{trans('reservation-modal.from_date')}}:</strong> <span
                        id="start"></span>
                </p>
                <p>
                    <strong>{{trans('reservation-modal.to_date')}}:</strong> <span id="end"></span>
                </p>
                <p>
                    <strong>{{trans('reservation-modal.duration')}}:</strong> <span id="duration"></span>
                    <span>{{trans('reservation-modal.hours')}}</span>
                </p>

            </div>
            <div class="modal-footer">
                <form id="deleteReservationForm" style="display: inline" class="form-inline" method="POST">
                    @csrf
                    @method('DELETE')
                    <button id="deleteReservation" type="submit"
                            class="btn btn-danger hidden">{{trans('reservation-modal.delete')}}</button>
                </form>
                <button type="button" id="updateReservation"  class="btn btn-info hidden"
                        data-dismiss="modal">{{trans('reservation-modal.update')}}</button>
                <button type="button" class="btn btn-primary"
                        data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
            </div>
        </div>
    </div>
</div>
