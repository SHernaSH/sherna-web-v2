@php
$index = 0;
@endphp

@foreach(\App\Models\Members\Member::orderBy('order')->get() as $member)
    @forelse($member->actives as $active)
        @php
        $index++;
        @endphp
        @if($index % 2 == 1)
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="card left-card">
                        <div class="row is-flex">
                            <div class="col-md-6 col-xs-6 person-image text-center">
                                <img src="{{url('/docs/members/' . $active->img)}}" class="img-responsive" alt="Person image">
                            </div>
                            <div class="col-md-6 col-xs-6 person-description">
                                <div><h3>{{$active->name}}</h3>
                                    <h4>{{$active->nickname}}</h4>
                                    <h5>{{$member->name}}</h5>
                                    <div>{{$active->room}}<br>
                                        <a href="mailto:{{$active->email}}">{{$active->email}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-6 col-md-offset-6 col-xs-12">
                    <div class="card right-card">
                        <div class="row is-flex">
                            <div class="col-md-6 col-xs-6 person-image text-center">
                                <img src="{{url('/docs/members/' . $active->img)}}" class="img-responsive" alt="Person image">
                            </div>
                            <div class="col-md-6 col-xs-6 person-description">
                                <div><h3>{{$active->name}}</h3>
                                    <h4>{{$active->nickname}}</h4>
                                    <h5>{{$member->name}}</h5>
                                    <div>{{$active->room}}<br>
                                        <a href="mailto:{{$active->email}}">{{$active->email}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h3>{{$member->name}}</h3>
                <p>No active members for this role</p>
            </div>
        </div>
    @endforelse
@endforeach

