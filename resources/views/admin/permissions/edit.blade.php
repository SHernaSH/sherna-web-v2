@extends('layouts.admin')


@section('content')

	<form action="{{route('permission.update',$permission->id)}}" class="" method="post">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit badge</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('permission.index')}}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name" name="name" value="{{$permission->name ?:  old('name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-4 control-label">Description</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="description" name="description" value="{{$permission->description ?:  old('description') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="controller" class="col-sm-4 control-label">Controller</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="controller" readonly value="{{$permission->controller ?:  old('controller') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="method" class="col-sm-4 control-label">Method</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="method" readonly value="{{$permission->method ?:  old('method') }}">
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
