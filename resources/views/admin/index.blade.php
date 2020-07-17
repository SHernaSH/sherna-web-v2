@extends('layouts.admin')

@section('content')
	<div class="row">
		@foreach(\App\Models\Locations\Location::get() as $location)
			<div class="col-md-4">
				<div class="x_panel">
					<div class="x_title">
						<h2>Actual reservation for: <b>{{$location->name}}</b></h2>
						<div class="pull-right">
							<span class="label label-{{$location->status->opened ? 'success':'danger'}}">{{$location->status->name}}</span>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">

						<?php

						$actualReservation = \App\Models\Reservations\Reservation::where('location_id', $location->id)
							->where('start_at', '<=', date('Y-m-d H:i:s'))
							->where('end_at', '>=', date('Y-m-d H:i:s'))->first();
						?>

						@if($actualReservation!=null)

							<div class="twPc-div">
{{--								<a class="twPc-bg twPc-block"></a>--}}

								<div>

									<a title="{{$actualReservation->user->name}}" target="_blank" rel="noopener"
									   href="https://is.sh.cvut.cz/users/{{$actualReservation->user->id}}"
									   class="twPc-avatarLink">
										<img alt="{{$actualReservation->user->name}}"
											 src="{{$actualReservation->user->image}}"
											 class="twPc-avatarImg">
									</a>

									<div class="twPc-divUser">
										<div class="twPc-divName">
											<a href="https://is.sh.cvut.cz/users/{{$actualReservation->user->id}}"
											   target="_blank"
											   rel="noopener">{{$actualReservation->user->name}}</a>
										</div>
										<span>
                                            <a href="mailto:{{$actualReservation->user->email}}"><span>{{$actualReservation->user->email}}</span></a>
                                        </span>
									</div>

									<div class="twPc-divStats">
										<ul class="twPc-Arrange">
											<li class="twPc-ArrangeSizeFit">
												<a href="#"
												   title="{{$actualReservation->start_at->isoFormat('LLL')}}">
													<span class="twPc-StatLabel twPc-block">Start</span>
													<span class="twPc-StatValue">{{ $actualReservation->start_at->isoFormat('LLL') }}</span>
												</a>
											</li>
											<li class="twPc-ArrangeSizeFit">
												<a href="#"
												   title="{{ $actualReservation->end_at->isoFormat('LLL') }}">
													<span class="twPc-StatLabel twPc-block">End</span>
													<span class="twPc-StatValue">{{ $actualReservation->end_at->isoFormat('LLL') }}</span>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>

						@else
							<h3 class="text-success">Free</h3>
						@endif
					</div>
				</div>
			</div>
		@endforeach
	</div>

@endsection
