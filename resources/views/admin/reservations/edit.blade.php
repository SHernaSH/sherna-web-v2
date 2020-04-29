@extends('layouts.admin')

@section('content')

	<form action="{{ route('admin.reservation.update', ['reservation' => $reservation]) }}" class="" method="post">
		@csrf
        @method('PUT')
		<div class="row">
			<div class="col-md-12">

				@include('admin.partials.form_errors')

				<div class="x_panel">
					<div class="x_title">
						<h2>Edit reservation</h2>
						<div class="pull-right">
                            @if(!isset($reservation->deleted_at) && !$reservation->end_at->isPast())
							    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            @endif
							<a href="{{ route('admin.reservation.index') }}" class="btn btn-primary"><i
										class="fa fa-arrow-left"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>


					<div class="row">
						<div class="col-md-12">
							@if(Auth::user()->isSuperAdmin())
								<div class="form-group">
									<label for="user"
										   class="control-label">User UID</label>
									<input type="text" class="form-control" name="user"
										   id="user" value="{{old('user', $reservation->user->id)}}">
								</div>
							@endif

							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="from_date"
											   class="control-label">From<span
													class="text-danger">*</span></label>
										<input name="from_date" class="form-control form_datetime" id="from_date"
											   type="text" value="{{old('from_date', $reservation->start_at->format('d.m.Y - h:i:s'))}}">
									</div>
									<div class="col-md-6">
										<label for="to_date"
											   class="control-label">To<span
													class="text-danger">*</span></label>
										<input name="to_date" class="form-control to_datetime" id="to_date"
											   type="text" value="{{old('to_date',$reservation->end_at->format('d.m.Y - h:i:s'))}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="visitors_count"
									   class="control-label">Location</label>
								<select name="location" id="" class="form-control">
									@foreach(\App\Models\Locations\Location::get() as $location)
										<option value="{{$location->id}}" {{old('location',$reservation->location_id)==$location->id ? 'selected':''}}>{{ $location->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="visitors_count"
									   class="control-label">Count of visitors</label>
								<input type="number" class="form-control" name="visitors_count"
									   id="visitors_count" min="0"
									   value="{{old('visitors_count', $reservation->visitors_count)}}">
							</div>

							<div class="form-group">
								<label for="note"
									   class="control-label">Note</label>
								<textarea class="form-control" id="note" name="note"
										  rows="3">{{old('note',$reservation->note)}}</textarea>
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
@include('admin.assets.autocomplete', ['url' => route('user.auto'), 'selector' => '#user'])
