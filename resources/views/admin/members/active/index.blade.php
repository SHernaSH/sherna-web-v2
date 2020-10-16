<label class="col-sm-2 control-label">actives:</label>
<div class="col-sm-10">
<table class=" table table-striped table-bordered table-responsive-md sorted_table" id="sorting_table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Room</th>
        <th>Order</th>
        <th>Public</th>
        {{--                                <th>Datum vytvoření</th>--}}
        {{--                                <th>Datum poslední změny</th>--}}
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($actives as $sub)
        <tr>
            <td>
                {{ $sub->name }}
            </td>
            <td>{{ $sub->email }}</td>
            <td>{{ $sub->room }}</td>
            <td>{{ $sub->order }}</td>
            <td><span class="label label-{{$sub->public ? 'success':'warning'}}">{{$sub->public ? 'Public':'In prepare'}}</span></td>
            {{--                                    <td>{{ $sub->created_at->isoFormat('LLL') }}</td>--}}
            {{--                                    <td>{{ $sub->updated_at->isoFormat('LLL') }}</td>--}}
            <td>
                <a class="btn btn-warning click-modal" href="#" data-toggle="modal" data-target="#view-modal"
                   data-url="{{ route('active.edit', ['active' => $sub->id])}}"><i
                        class="fa fa-pencil"></i></a>
                <a href="{{ route('active.public', ['active' => $sub->id]) }}" class="btn btn-{{$sub->public ? "danger" : "primary"}} primary"><i
                        class="fa {{$sub->public ? "fa-eye-slash" : "fa-eye"}} "></i></a>
                <a href="#" class="delete btn btn-danger" data-url="{{route('active.destroy', ['active' => $sub->id]) }}"><i class="fa fa-trash"></i></a>

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">
                No active members yet
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

@include('admin.assets.modal.button-modal', [
    'route' => route('active.create'),
    'btnText' => 'Add active member',
    ])

</div>
