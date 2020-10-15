@extends('layouts.client')

@push('styles')
    <link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <style>
        .activate {
            margin-left: 25px;
            width: 30%;
        }

        .activate:hover .activate-label {
            display: none;
        }
        .activate.hour:hover:after {
            content: '-{{ \App\Models\Settings\Setting::where('name', 'Points for one hour')->first()->value }}';
        }
        .activate.hours:hover:after {
            content: '-{{ \App\Models\Settings\Setting::where('name', 'Points for eight hours')->first()->value }}';

        }

        .activate.extra:hover:after {
            content: '-{{ \App\Models\Settings\Setting::where('name', 'Points for extra reservation')->first()->value }}';
        }

        .b {
            font-weight: 600;
            font-size: 1.6rem;
        }

        h4 {
            height: 40%;
            margin: 0 15px 25px 0;
        }

    </style>
@endpush

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{trans('reservations.your_points')}}</h2>
                    </div>
                </div>

                <div class="row text-center mb-2">
                    @php
                        $maxDuration = \App\Models\Settings\Setting::where('name', 'Maximal Duration')->first()->value;
                    @endphp
                    <div class="col-md-4">
                        <h4>{{trans('reservations.add_hour') . " (max $maxDuration)" }}</h4>
                        <div>
                            <form action="{{ route('user.upgrade', ['type' => 'hour']) }}" class="inline">
                            <span class="b">{{$user->extraHours()}}</span>
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-blue activate hour {{$user->extraHours() >= $maxDuration ? "hidden" : ''}}" type="submit">
                                            <span class="align activate-label">{{ trans('reservations.activate') }}</span>
                                        </button>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4>{{trans('reservations.add_max_hours') . " (max $maxDuration)" }}</h4>
                        <div>
                            <form action="{{ route('user.upgrade', ['type' => 'hours']) }}" class="inline">
                                <span class="b">{{$user->extraHours()}}</span>
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-blue activate hours {{$user->extraHours() != 0 ? "hidden" : ''}}" type="submit">
                                            <span class="align activate-label">{{ trans('reservations.activate') }}</span>
                                        </button>
                            </form>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4>{{trans('reservations.add_extra')}}</h4>
                        <div>
{{--                            @if($user->extraReservation())--}}

{{--                            @else--}}
                                <form action="{{ route('user.upgrade', ['type' => 'double']) }}" class="inline">
                                    <span class="b">{{ $user->extraReservation() ? 1 : 0}}</span>
                                    @csrf
                                    @method('PUT')
{{--                                    <span class="invisible b">0</span>--}}
                                    <button class="btn btn-blue activate extra {{$user->extraReservation() ? "hidden" : ''}}" type="submit">
                                        <span class="align activate-label">{{ trans('reservations.activate') }}</span>
                                    </button>
                                </form>
{{--                            @endif--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        @if($reservation->isActive() || $reservation->isFuture())
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


