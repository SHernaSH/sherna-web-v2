@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>events</h2>
					<div class="pull-right">
						<a class="btn btn-primary" href="{{ route('admin.event.create')}}"><i
									class="fa fa-plus"></i></a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">

					<table class="table">
						<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
                            <th>Location</th>
							<th>Points</th>
							<th>Start</th>
							<th>End</th>
                            <th>Canceled</th>
							<th>Users</th>
                            <th>QR Code</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@forelse($events as $event)
							<tr class="{{$event->end_at->isPast() || isset($event->deleted_at) ? 'success':''}}">
								<th>{{ $events->total() - ($loop->index) - ($events->perPage() * ($events->currentPage() - 1))}}</th>
								<td>{{ $event->name }}</td>
								<td>{{ $event->location->name }}</td>
								<td>{{ $event->points }}</td>
                                <td>{{ $event->start_at->isoFormat('LLL') }}</td>
                                <td>{{ $event->end_at->isoFormat('LLL') }}</td>
								<td>
									@if(isset($event->deleted_at))
										{{ $event->deleted_at }}
									@else
										-
									@endif
								</td>
								<td>{{ $event->users()->count() }}</td>
                                <td><a href="{{ route('admin.event.download', ['event' => $event]) }}" class="btn btn-default"><i
                                            class="fa fa-download"></i></a></td>
								<td>
                                    <form action="{{ route('admin.event.destroy', ['event' => $event]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('admin.event.edit',['event' => $event->id])}}"
                                           class="btn btn-default"><i class="fa fa-pencil"></i></a>
                                        @if(!isset($event->deleted_at) && !$event->end_at->isPast())
                                            <a href=""
                                               class="btn btn-warning"><i class="fa fa-times"></i></a>
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                        @endif
                                    </form>
								</td>
							</tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="9">No events yet</td>
                            </tr>
						@endforelse
						</tbody>
                    @if($events->hasPages())
                        <tr>
                            <td class="text-center" colspan="7">{{ $events->links() }}</td>
                        </tr>
                    @endif
                    </table>
                </div>
			</div>
		</div>
	</div>

@endsection
