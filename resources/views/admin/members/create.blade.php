@extends('layouts.admin')

@section('content')


    <form action="{{ route('member.store')}}" class="form-horizontal" method="post">
        @csrf
        <input type="hidden" name="url" id="url">
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create member</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('member.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="public">Make public:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="public" id="public" {{old('is_public') || old('public') ? 'checked' : ''}} class="js-switch" />
                            </div>
                        </div>

                        @include('admin.assets.modal.modal-form', ['title' => 'Active'])


                        <ul class="nav nav-tabs" style="margin-bottom: 3%">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <li class="{{($language->id==1 ? "active":"")}}">
                                    <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <div class=" tab-pane fade {{($language->id==1 ? "active":"")}} in" id="{{$language->id}}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="name-{{$language->id}}">Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="name-{{$language->id}}" name="name-{{$language->id}}" class="form-control"
                                                   value="{{old('name-' . $language->id) }}">
                                        </div>
                                    </div>
                                    <div class="is_dropdown form-group">
                                        @include('admin.members.active.index', [
                                                        'actives' => \Session::get('actives', collect())->sortBy('order'),
                                                        'lang_id' => $language->id,
                                                    ])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@include('admin.assets.switchery')
@include('admin.assets.delete_modal')
@include('admin.assets.sortable', ['selector' => '.sorted_table', 'id' => 'sorting_table', 'route' => route('active.reorder') ]);


