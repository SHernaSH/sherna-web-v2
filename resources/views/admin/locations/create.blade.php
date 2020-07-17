@extends('layouts.admin')

@section('content')

    <form action="{{ route('location.store') }}" class="form-horizontal" method="post">
        @csrf
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
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <li class="{{($language->id==1 ? "active":"")}}">
                                    <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content row">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <div class="tab-pane col-md-6 fade {{($language->id==1 ? "active":"")}} in" id="{{$language->id}}">
                                    <div class="form-group">
                                        <label for="name-{{$language->id}}" class="col-sm-4 control-label">Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="name-{{$language->id}}" id="name-{{$language->id}}" class="form-control" value="{{ old('name-' . $language->id) }}" required minlength="3" maxlength="80" />
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
                                        <input type="text" class="form-control" id="location_uid" name="location_uid" required value="{{ old('location_uid') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reader_uid" class="col-sm-4 control-label">Reader UID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="reader_uid" name="reader_uid" required value="{{ old('reader_uid') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-4 control-label">Locations status</label>
                                    <div class="col-sm-8">
                                        <select name="status" id="status" class="form-control" required>
                                            @foreach(\App\Models\Locations\LocationStatus::all() as $status)
                                                <option value="{{$status->id}}"}}>
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
