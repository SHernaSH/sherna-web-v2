<label class="col-sm-2 control-label">Subpages:</label>
<div class="col-sm-10">
<table class=" table table-striped table-bordered table-responsive-md sorted_table" id="sorting_table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Url</th>
        <th>Order</th>
        <th>Public</th>
        {{--                                <th>Datum vytvoření</th>--}}
        {{--                                <th>Datum poslední změny</th>--}}
        <th></th>
    </tr>
    </thead>
    <tbody>
    @forelse($subpages as $sub)
        <tr>
            <td>
                {{ $sub->name }}
            </td>
            <td>{{ $sub->url }}</td>
            <td>{{ $sub->order }}</td>
            <td><span class="label label-{{$sub->public ? 'success':'warning'}}">{{$sub->public ? 'Public':'In prepare'}}</span></td>
            {{--                                    <td>{{ $sub->created_at->isoFormat('LLL') }}</td>--}}
            {{--                                    <td>{{ $sub->updated_at->isoFormat('LLL') }}</td>--}}
            <td>
                <a class="btn btn-warning click-modal" href="#" data-toggle="modal" data-target="#view-modal"
                   data-url="{{ route('subnavigation.edit', ['subnavigation' => $sub->url])}}"><i
                        class="fa fa-pencil"></i></a>
                <a href="{{ route('subnavigation.public', ['subnavigation' => $sub->url]) }}" class="btn btn-{{$sub->public ? "danger" : "primary"}} primary"><i
                        class="fa {{$sub->public ? "fa-eye-slash" : "fa-eye"}} "></i></a>
                <a href="#" class="delete btn btn-danger" data-url="{{route('subnavigation.destroy', ['subnavigation' => $sub->url]) }}"><i class="fa fa-trash"></i></a>

            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">
                No subpages yet
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

@include('admin.assets.modal.button-modal', [
    'route' => route('subnavigation.create'),
    'btnText' => 'Pridaj podstranku',
    ])

</div>
