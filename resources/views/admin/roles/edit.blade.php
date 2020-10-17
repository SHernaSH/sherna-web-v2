@extends('layouts.admin')

@section('content')

    <form action="{{ route('role.update', ['role' => $role]) }}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update role</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('role.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $role->name ?: old('name') }}" required minlength="3" maxlength="80" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="col-sm-4 control-label">Description</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="description" id="description" class="form-control" value="{{ $role->description ?: old('description') }}" required minlength="3" maxlength="80" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="parent_id" class="col-sm-4 control-label">Parent role to inherit permissions</label>
                                    <div class="col-sm-8">
                                        <select name="parent_id" id="parent_id" class="form-control">
                                            @if($role->parent_id == null)
                                                <option selected value> -- select a role to inherit -- </option>
                                            @endif
                                            @foreach(\App\Models\Roles\Role::where('id', '!=', $role->id)->get() as $inher)
                                                <option {{ $role->parent_id == $inher->id ? 'selected' : ''}} value="{{ $inher->id }}">{{ $inher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="permissions" class="col-sm-4 control-label">Permissions</label>
                                    <div class="col-sm-8">
                                        <select id="permission" name="permissions[]" multiple style="height: 500px">
                                            @foreach(\App\Models\Permissions\Permission::all() as $permission)
                                                <option value="{{$permission->id}}" title="{{$permission->description}}" {{ $role->hasPermission($permission, true) ? 'selected' : ''}}>
                                                    {{$permission->name ?? $permission->controller . '@' . $permission->method}}
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
