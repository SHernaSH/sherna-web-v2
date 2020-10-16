@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Members</h2>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('member.create') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table id="sorting_table" class="table sorted_table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="hidden">Id</th>
                            <th>Order</th>
                            <th>Public</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td class="hidden">{{ $member->id }}</td>
                                <td>{{ $member->order }}</td>
                                <td><span class="label label-{{$member->public ? 'success':'warning'}}">{{$member->public ? 'Public':'In prepare'}}</span></td>
                                <td>
                                        @forelse($member->actives as $active)
                                            <span class="label label-info">{{ $active->name }}</span>
                                        @empty
                                            <span class="label label-warning"> No active members</span>
                                        @endforelse
                                </td>
{{--                                <td>{{ $member->user->name }}</td>--}}
                                <td></td>
                                <td>
                                    <form action="{{ route('member.destroy', ['member' => $member->id]) }}" class="inline" method="post">
                                        @csrf
                                        @method('DELETE')
                                            <a class="btn btn-warning" href="{{ route('member.edit' ,['member' => $member->id]) }}"><i
                                                class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                             <a href="{{ route('member.public', ['member' => $member->id]) }}" class="btn btn-{{$member->public ? "danger" : "primary"}} primary"><i
                                                class="fa {{$member->public ? "fa-eye-slash" : "fa-eye"}} "></i></a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">No members yet</td>
                            </tr>
                        @endforelse
                        @if($members->hasPages())
                            <tr>
                                <td class="text-center" colspan="7">{{ $members->links() }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('admin.assets.sortable', ['selector' => '.sorted_table', 'id' => 'sorting_table', 'route' => route('member.reorder') ]);
