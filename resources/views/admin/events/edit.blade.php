@extends('layouts.admin')

@section('content')

	<form action="{{ route('admin.event.update', ['event' => $event]) }}" class="" method="post">
		@csrf
        @method('PUT')
		<div class="row">
			<div class="col-md-12">

				@include('admin.partials.form_errors')

				<div class="x_panel">
					<div class="x_title">
						<h2>Edit event</h2>
						<div class="pull-right">
                            <a href="{{ route('admin.event.download', ['event' => $event]) }}" class="btn btn-dark"><i
                                    class="fa fa-download"></i></a>

                        @if(!isset($event->deleted_at) && !$event->start_at->isPast())
							    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            @endif
							<a href="{{ route('admin.event.index') }}" class="btn btn-primary"><i
										class="fa fa-arrow-left"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>


					<div class="row">
						<div class="col-md-12">
							@if(Auth::user()->isSuperAdmin())
								<div class="form-group">
									<label for="name"
										   class="control-label">Name</label>
									<input type="text" class="form-control" name="name"
										   id="name" value="{{old('name', $event->name)}}">
								</div>
							@endif

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="from_date"
											   class="control-label">From<span
													class="text-danger">*</span></label>
										<input name="from_date" class="form-control form_datetime" id="from_date"
											   type="text" value="{{old('from_date', $event->start_at->format('d.m.Y H:i'))}}">
									</div>
									<div class="col-md-6">
										<label for="to_date"
											   class="control-label">To<span
													class="text-danger">*</span></label>
										<input name="to_date" class="form-control to_datetime" id="to_date"
											   type="text" value="{{old('to_date',$event->end_at->format('d.m.Y H:i'))}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="location"
									   class="control-label">Location</label>
								<select name="location_id" id="location" class="form-control">
									@foreach(\App\Models\Locations\Location::get() as $location)
										<option value="{{$location->id}}" {{old('location',$event->location_id)==$location->id ? 'selected':''}}>{{ $location->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="points"
									   class="control-label">Points for attending</label>
								<input type="number" class="form-control" name="points"
									   id="points" min="0"
									   value="{{old('visitors_count', $event->points)}}">
							</div>
                                <div class="form-group">
                                    <label for="points"
                                           class="control-label">QR Code</label>
                                    <div class="text-center">
                                        {!! $event->QRCode() !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tags"
                                           class="control-label">Users</label>
                                        <input name="tags" value="{{ old('tags') }}
                                        @foreach($event->users as $user)
                                        {{$user->name}}
                                        @endforeach" id="tags"/>
                                </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

@endsection

@include('admin.assets.datetimepicker')
@include('admin.assets.jq_ui')
@include('admin.assets.tags', [
    'route' => route('user.auto.tags'), 'interactive' => 0, 'defaultText' => '', 'delimeter' => ' '
])
