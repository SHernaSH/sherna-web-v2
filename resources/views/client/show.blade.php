@extends('layouts.client')

@section('styles')
	{{--<link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">--}}
	{{--<link href="{{secure_asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet" media="print">--}}
	<link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
	<link href="{{asset('gentellela/vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet"
		  media="print">
	<style>
		#calendar {
			max-width: 900px;
			margin: 0 auto;
		}
	</style>
	
	
	@if($page->code=='rezervace' && \App\Models\Location::whereHas('status',function ($q) {$q->where('opened',true);})->count() > 0)
		<link href="{{asset('assets_client/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
	@endif
@endsection

@section('content')
	
	<div class="container">
		
		<div class="row">
			<div class="col-md-12 col-xs-12">
				{!! $page->pageText()->ofLang(Config::get('app.locale'))->first()->content !!}
			</div>
		</div>
		
		
		@if($page->code=='vybaveni')
			@foreach(\App\Models\InventoryCategory::get() as $category)
				<div class="row">
					<div class="col-md-12 inventory-items" id="inventory-items">
						<h2>
							{{$category->texts()->ofLang(Config::get('app.locale'))->first()->name}}
						</h2>
						
						<hr>
						@if($category->id == 1)
							
							@php
								$lastConsole = null;
								$lastConsole2 = null;
							@endphp
							@foreach($category->items()->orderBy('console_id')->orderBy('name','asc')->get() as $categoryItem)
								
								@if($categoryItem->consoleObj!=null && ($lastConsole==null || $lastConsole->id!=$categoryItem->consoleObj->id))
									
									
									@if($lastConsole!=null)
					</div>
					@endif
					@php
						$lastConsole = $categoryItem->consoleObj;
					@endphp
					
					<h3 data-toggle="collapse" data-parent="#inventory-items" class="collapsed"
						href="#collapse{{$categoryItem->consoleObj->id}}" aria-expanded="true"
						aria-controls="collapse{{$categoryItem->consoleObj->id}}">
						{{$categoryItem->consoleObj->name}}
							<i class="fa fa-chevron-circle-down cursor"></i>
					</h3>
					
					<div class="collapse" id="collapse{{$categoryItem->consoleObj->id}}">
						@endif
						
						<div class="game-item">
											<span class="game-name">
												<b>{{$categoryItem->name}}</b>
											</span>
							<ul class="game-options">
								<li>{{trans('games.players')}}: <span
											class="label label-default">{{$categoryItem->players}}</span>
								</li>
								@if($categoryItem->consoleObj!=null && $categoryItem->consoleObj->type->name == 'PlayStation')
									<li>{{trans('games.vr')}}: <span
												class="label label-{{$categoryItem->vr ? 'success' : 'danger'}}">{{$categoryItem->vr ? trans('general.yes') : trans('general.no')}}</span>
									</li>
									<li>{{trans('games.move')}}: <span
												class="label label-{{$categoryItem->move ? 'success' : 'danger'}}">{{$categoryItem->move ? trans('general.yes') : trans('general.no')}}</span>
									</li>
								@endif
								<li>{{trans('games.game_pad')}}: <span
											class="label label-{{$categoryItem->game_pad ? 'success' : 'danger'}}">{{$categoryItem->game_pad ? trans('general.yes') : trans('general.no')}}</span>
								</li>
								@if($categoryItem->consoleObj!=null && $categoryItem->consoleObj->type->name == 'Xbox')
									<li>{{trans('games.kinect')}}: <span
												class="label label-{{$categoryItem->kinect ? 'success' : 'danger'}}">{{$categoryItem->kinect ? trans('general.yes') : trans('general.no')}}</span>
									</li>
									<li>{{trans('games.guitar')}}: <span
												class="label label-{{$categoryItem->guitar ? 'success' : 'danger'}}">{{$categoryItem->guitar ? trans('general.yes') : trans('general.no')}}</span>
									</li>
								@endif
							</ul>
						</div>
						
						@endforeach
					</div>
					@else
						<ul>
							@foreach($category->items as $categoryItem)
								<li>
									{{$categoryItem->name}}
								</li>
							@endforeach
						</ul>
					@endif
				</div>
	</div>
	@endforeach
	@endif
	</div>
	
	<br>
	
	@if($page->code=='rezervace' && \App\Models\Location::whereHas('status',function ($q) {$q->where('opened',true);})->count() > 0)
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3 col-xs-12">
					<div class="row">
						@foreach(\App\Models\Location::get() as $location)
							<div class="col-md-6 col-xs-6 text-center">
								<p class="location_radio">
									@if($location->status->name == 'On key')
										<input id="location{{$location->id}}" type="radio" name="location"
											   value="{{$location->id}}"
											   autocomplete="off">
										<label for="location{{$location->id}}">
											<i class="location-state on_key">{{trans('general.on_key')}}</i>
											<i class="fa fa-building"></i> {{$location->name}}
										</label>
									@else
										<input id="location{{$location->id}}" type="radio" name="location"
											   value="{{$location->id}}"
											   autocomplete="off" {{$location->status->opened?'checked="checked"':''}}>
										<label for="location{{$location->id}}">
											<i class="location-state {{$location->status->opened ?'opened':'closed'}}">{{$location->status->opened ?trans('general.opened'):trans('general.closed')}}</i>
											<i class="fa fa-building"></i> {{$location->name}}
										</label>
									@endif
								</p>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6 col-md-offset-3 text-center">
					@if(Auth::check())
						@if(Auth::user()->reservations()->futureActiveReservations()->count() > 0)
							<span class="text-danger"><b>{{trans('general.future_reservations')}}</b></span>
						@else
							<a href="#" data-toggle="modal" data-target="#createReservationModal"
							   class="btn btn-default">{{trans('reservation-modal.title')}}</a>
						@endif
					@else
						<a href="{{action('Client\ClientController@getAuthorize')}}"
						   class="btn btn-default">{{trans('reservation-modal.title')}}</a>
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
				<div class="col-md-12">
					<div id="calendar"></div>
				</div>
			</div>
		</div>
		
		
		<!-- Modal -->
		<div class="modal fade" id="createReservationModal" tabindex="-1" role="dialog"
			 aria-labelledby="createReservationModalLabel">
			<div class="modal-dialog" role="document">
				<form action="#" class="" method="post">
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
												   id="from_date"
												   type="text">
										</div>
										<div class="col-md-6">
											<label for="to_date"
												   class="control-label">{{trans('reservation-modal.to_date')}}
												<span
														class="text-danger">*</span></label>
											<input name="to_date" class="form-control to_datetime"
												   id="to_date"
												   type="text">
										</div>
									</div>
									<div class="form-group">
										<label for="visitors_count"
											   class="control-label">{{trans('reservations.location')}}</label>
										<select name="location_id" id="" class="form-control">
											@foreach(\App\Models\Location::opened()->get() as $location)
												<option value="{{$location->id}}" {{old('location')==$location->id ? 'selected':''}}>{{$location->name}}</option>
											@endforeach
										</select>
									</div>
									
									<div class="form-group">
										<label for="visitors_count"
											   class="control-label">{{trans('reservation-modal.visitors_count')}}</label>
										<input type="number" class="form-control" name="visitors_count"
											   id="visitors_count">
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
					
					</div>
					<div class="modal-footer">
						<button id="deleteReservation" type="button"
								class="btn btn-danger hidden">{{trans('reservation-modal.delete')}}</button>
						<button type="button" class="btn btn-primary"
								data-dismiss="modal">{{trans('reservation-modal.cancel')}}</button>
					</div>
				</div>
			</div>
		</div>
	@endif

@endsection


@section('scripts')

@endsection
