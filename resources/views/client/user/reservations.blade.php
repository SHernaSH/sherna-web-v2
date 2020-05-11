@extends('layouts.client')

@push('styles')
    <link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
@endpush

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{trans('reservations.your_reservations')}}</h2>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{trans('reservations.from_date')}}</th>
                            <th>{{trans('reservations.to_date')}}</th>
                            <th>{{trans('reservations.location')}}</th>
                            <th>{{trans('reservations.canceled')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reservations as $reservation)
                            <tr class="{{$reservation->end_at->isPast() || isset($reservation->deleted_at) ? 'success':''}}">
                                <td>{{$reservation->start_at->isoFormat('LLL')}}</td>
                                <td class="end-date">{{$reservation->end_at->isoFormat('LLL')}}</td>
                                <td>{{$reservation->location->name}}</td>
                                <td>{{$reservation->deleted_at == null ? '-' : $reservation->deleted_at->isoFormat('LLL')}}</td>
                                <td>
                                    <form action="{{ route('user.reservations.delete',['reservation' =>$reservation]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        @if($reservation->isFuture())
                                        <a class="btn btn-primary" href="{{ route('user.ics', ['reservation' => $reservation]) }}"><i
                                                class="fa fa-calendar"></i></a>
                                        @endif
                                        @if($reservation->isActive())
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
{{--                                        <a class="btn btn-danger btn-delete"--}}
{{--                                           href="{{ route('user.reservations.delete',['reservation' =>$reservation]) }}">--}}
{{--                                            {{trans('reservation-modal.delete')}}--}}
{{--                                        </a>--}}
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    {{ trans('general.empty.reservation') }}
                                </td>
                            </tr>
                        @endforelse
                        @if($reservations->hasPages())
                            <tr>
                                <td class="text-center" colspan="5">{{ $reservations->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection


