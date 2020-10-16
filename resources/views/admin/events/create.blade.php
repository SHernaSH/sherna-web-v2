@extends('layouts.admin')

@section('content')

	<form action="{{ route('admin.event.store') }}" class="" method="post">
		@csrf
		<div class="row">
			<div class="col-md-12">

				@include('admin.partials.form_errors')

				<div class="x_panel">
					<div class="x_title">
						<h2>Create event</h2>
						<div class="pull-right">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
							<a href="{{ route('admin.event.index') }}" class="btn btn-primary"><i
										class="fa fa-arrow-left"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>


					<div class="row">
						<div class="col-md-12">
                            <div class="form-group">
                                <label for="name"
                                       class="control-label">Name</label>
                                <input type="text" class="form-control" name="name"
                                       id="name" value="{{old('name')}}">
                            </div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6">
										<label for="from_date"
											   class="control-label">From<span
													class="text-danger">*</span></label>
										<input name="from_date" class="form-control form_datetime" id="from_date"
											   type="text" autocomplete="off"  value="{{old('from_date')}}">
									</div>
									<div class="col-md-6">
										<label for="to_date"
											   class="control-label">To<span
													class="text-danger">*</span></label>
										<input name="to_date" class="form-control to_datetime" id="to_date"
											   type="text" autocomplete="off"  value="{{old('to_date')}}">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="location"
									   class="control-label">Location</label>
								<select name="location_id" id="location" class="form-control">
									@foreach(\App\Models\Locations\Location::all() as $location)
										<option value="{{$location->id}}" {{old('location')==$location->id ? 'selected':''}}>{{$location->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="points"
									   class="control-label">Points for attending</label>
								<input type="number" class="form-control" name="points"
									   id="points" min="0" value="{{old('points', 0)}}">
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
