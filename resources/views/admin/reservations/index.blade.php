@extends('layouts.admin')

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Reservations</h2>
					<div class="pull-right">
						<a class="btn btn-primary" href="{{ route('admin.reservation.create')}}"><i
									class="fa fa-plus"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<table class="table">
						<thead>
						<tr>
							<th>#</th>
							<th>Owner</th>
							<th>Contact</th>
							<th>Location</th>
							<th>Start</th>
							<th>End</th>
							<th>Canceled</th>
							<th>Note</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@forelse($reservations as $reservation)
							<tr class="{{$reservation->end_at->isPast() || isset($reservation->deleted_at) ? 'success':''}}">
								<th>{{ $reservations->total() - ($loop->index) - ($reservations->perPage() * ($reservations->currentPage() - 1))}}</th>
								<td>{{ $reservation->user->name }}</td>
								<td>
                                    <a href="mailto:{{ $reservation->user->email }}">{{ $reservation->user->email }}</a>
{{--									@if($reservation->owner==null)--}}
{{--										{{$reservation->ownerEmail()}}--}}
{{--									@else--}}
{{--										<a href="mailto:{{$reservation->owner->email}}">{{$reservation->owner->email}}</a>--}}
{{--									@endif--}}
								</td>
								<td>{{ $reservation->location->name }}</td>
                                <td>{{ $reservation->start_at->isoFormat('LLL') }}</td>
                                <td>{{ $reservation->end_at->isoFormat('LLL') }}</td>
								<td>
									@if(isset($reservation->deleted_at))
										{{ $reservation->deleted_at }}
									@else
										-
									@endif
								</td>
								<td>{{$reservation->note}}</td>
								<td>
                                    <form action="{{ route('admin.reservation.destroy', ['reservation' => $reservation]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('admin.reservation.edit',['reservation' => $reservation->id])}}"
                                           class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                        @if(!isset($reservation->deleted_at) && !$reservation->end_at->isPast())
                                            <a href=""
                                               class="btn btn-warning"><i class="fa fa-times"></i></a>
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        @endif
                                    </form>
								</td>
							</tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">No reservations yet</td>
                            </tr>
						@endforelse
						</tbody>
                    @if($reservations->hasPages())
                        <tr>
                            <td class="text-center" colspan="7">{{ $reservations->links() }}</td>
                        </tr>
                    @endif
                    </table>
                </div>
			</div>
		</div>
	</div>

@endsection
