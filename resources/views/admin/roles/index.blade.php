@extends('layouts.admin')

@section('content')

    <div class="row">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Roles</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('role.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>{{ $role->created_at->isoFormat('LLL') }}</td>
                                <td>{{ $role->updated_at->isoFormat('LLL') }}</td>
                                <td>
                                    @if($role->name != 'super_admin')
                                    <form action="{{ route('role.destroy',$role->id) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-warning" href="{{ route('role.edit', $role->id) }}"><i
                                                    class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No roles so far.
                                </td>
                            </tr>
                        @endforelse
                        @if($roles->hasPages())
                            <tr>
                                <td class="text-center" colspan="5">{{ $roles->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>


    </div>

@endsection
