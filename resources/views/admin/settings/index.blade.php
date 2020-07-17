@extends('layouts.admin')

@section('content')

    <form action="{{ route('settings.update') }}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>System settings</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach ($settings as $setting)
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="value-{{$setting->id}}">{{$setting->name}}</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="number" name="value-{{$setting->id}}" id="value-{{$setting->id}}" class="form-control" value="{{$setting->value ?: old('value-' .$setting->id) }}" required />
                                                <span class="input-group-addon" id="basic-addon2">{{$setting->unit}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
