@extends('layouts.admin')

@section('content')

    <form action="{{ route('console.update', [ 'console' => $console]) }}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update console</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('console.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="name" value="{{$console->name}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Console type</label>
                                    <div class="col-sm-8">
                                        <select name="console_type_id" id="input2" class="form-control">
                                            @foreach(\App\Models\Consoles\ConsoleType::get() as $consoleType)
                                                <option value="{{$consoleType->id}}" {{$console->type->id == $consoleType->id ? 'selected':''}}>{{$consoleType->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Location</label>
                                    <div class="col-sm-8">
                                        <select name="location_id" id="input2" class="form-control">
                                            @foreach(\App\Models\Locations\Location::get() as $location)
                                                <option value="{{$location->id}}" {{$console->location->id == $location->id ? 'selected':''}}>{{$location->name}}</option>
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
