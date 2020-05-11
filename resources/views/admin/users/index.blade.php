@extends('layouts.admin')

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Users</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table">
						<thead>
						<tr>
							<th>UID</th>
							<th>Name</th>
							<th>Surname</th>
							<th>Email</th>
							@if(\Auth::user()->isSuperAdmin())
								<th>Role</th>
							@endif
							<th></th>
						</tr>
						</thead>
						<tbody>
						<tr>
                            <form class="form-inline" method="post" action="{{ route('user.filter') }}">
                                @csrf
                                <td>Search:</td>
                                <td>
                                    <input name="name" type="text" class="form-control input-xs"
                                               value="{{ old('name', $filters['name']) }}">
                                </td>
                                <td>
                                    <input name="surname" type="text" class="form-control input-xs"
                                           value="{{ old('surname', $filters['surname']) }}">
                                </td>
                                <td>
                                    <input name="email" type="text" class="form-control input-xs"
                                           value="{{ old('email', $filters['email']) }}">
                                </td>
                                <td>
                                    <select name="role_id">
                                        <option selected value> -- none -- </option>
                                        @foreach(\App\Models\Roles\Role::all() as $role)
                                            <option value="{{$role->id}}" {{ $role->id == $filters['role_id'] ? "selected" : "" }} >
                                                {{$role->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><i
                                                    class="fa fa-search"></i>
                                            </button>
                                        </span>
                                </td>
                            </form>
						</tr>
						@forelse($users as $user)
							<tr>
								<td><a target="_blank" rel="noopener"
									   href="https://is.sh.cvut.cz/users/{{$user->uid}}">{{$user->uid}}</a></td>
								<td>{{$user->name}}</td>
								<td>{{$user->surname}}</td>
								<td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
{{--								@if(Auth::user()->isSuperAdmin())--}}
									<td>
										<form action="{{ route('user.role', ['user' => $user])}}" class="form-inline"
											  method="post">
											@csrf
                                            @method('PUT')

											<div class="form-group">
												<select name="role" id="roles" class="form-control user_roles">
                                                    @foreach(\App\Models\Roles\Role::all() as $role)
                                                        <option value="{{$role->id}}" {{ $role->id == $user->role->id ? 'selected' : ''}}>
                                                            {{$role->name}}
                                                        </option>
                                                    @endforeach
												</select>
											</div>
										</form>
									</td>
{{--								@endif--}}
								<td>
{{--									@if(Auth::user()->isSuperAdmin())--}}
										@if(!$user->banned)
											<a class="btn btn-danger"
											   href="{{ route('user.ban',['user' => $user]) }}"><i
														class="fa fa-ban"></i></a>
										@else
											<a class="btn btn-success"
											   href="{{ route('user.ban',['user' => $user]) }}"><i
														class="fa fa-eraser"></i></a>
										@endif
{{--									@endif--}}
								</td>
							</tr>
                         @empty
                                <tr>
                                    <td class="text-center" colspan="7">No users</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($users->hasPages())
                            <tr>
                                <td class="text-center" colspan="6">{{ $users->links() }}</td>
                            </tr>
                        @endif
                    </table>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('scripts')

	<script type="text/javascript">

		$(document).on('change', '#roles', function (ev) {
			$(ev.target).closest('form').submit();
		});

	</script>

@endpush
