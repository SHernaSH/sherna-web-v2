@extends('layouts.admin')

@section('content')

    <form action="{{ route('location.edit', ['location' => $location->id]) }}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update location</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('location.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <ul class="nav nav-tabs" style="margin-bottom: 3%">
                            @foreach(\App\Language::all() as $language)
                                <li class="{{($language->id==$location->language->id ? "active":"")}}">
                                    <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content row">
                            @foreach(\App\Language::all() as $language)
                                @php
                                    $loc = \App\Location::where('id', $location->id)->ofLang($language)->first();
                                @endphp
                                <div class="tab-pane col-md-6 fade {{($language->id==$location->language->id ? "active":"")}} in" id="{{$language->id}}">
                                    <div class="form-group">
                                        <label for="name-{{$language->id}}" class="col-sm-4 control-label">Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="name-{{$language->id}}" id="name-{{$language->id}}" class="form-control" value="{{$loc->name ?: old('name-' . $language->id) }}" required minlength="3" maxlength="80" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location" class="col-sm-4 control-label">Location UID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="location_uid" name="location_uid" required value="{{$location->uid ?: old('location_uid')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reader_uid" class="col-sm-4 control-label">Reader UID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="reader_uid" name="reader_uid" required value="{{$location->uid ?: old('reader_uid')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-4 control-label">Locations status</label>
                                    <div class="col-sm-8">
                                        <select name="status" id="status" class="form-control">
                                            @foreach(\App\LocationStatus::all() as $status)
                                                <option value="{{$status->id}}" {{ $status->id == $location->status->id ? 'selected' : ''}}>
                                                    {{$status->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
