@extends('layouts.admin')

@php
    $is_dropdown = session()->get( 'is_dropdown', false ) || !empty(old('dropdown'));
@endphp
@section('content')


    <form action="{{ route('navigation.store')}}" class="form-horizontal" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create navigation</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('navigation.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="url">Url:</label>
                            <div class="col-sm-10">
                                <input type="text" name="url" id="url" minlength="3" maxlength="10" min="1" value="{{ old('url') }}" required/>
                            </div>
                        </div>

{{--                        <div class="form-group">--}}
{{--                            <label class="col-sm-2 control-label" for="order">Order:</label>--}}
{{--                            <div class="col-sm-10">--}}
{{--                                <input name="order" id="order" type="number" min="1" value="{{ old('order') }}" required/>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="url">Is dropdown:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="dropdown" id="dropdown" class="js-switch js-check-change"
                                    {{ $is_dropdown ? "checked" : "" }} />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="url">Make public:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" class="js-switch" />
                            </div>
                        </div>

                        @include('admin.assets.modal.modal-form', ['title' => 'Subpage'])


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
                                    <div class="not_dropdown {{$is_dropdown ? "d-none" : ""}}" >
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="content-{{$language->id}}">Content:</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" id="content-{{$language->id}}" name="content-{{$language->id}}"
                                                       value="{{ old('content-' . $language->id) }}" class="input-info" data-langID="{{$language->id}}">
                                                <div class="summernote" data-langID="{{$language->id}}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="is_dropdown form-group {{!$is_dropdown ? "d-none" : ""}}">
                                        @include('admin.navigation.subpages.index', [
                                                        'subpages' => \Session::get('subpages-' . $language->id, collect())->sortBy('order'),
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

@include('admin.assets.summernote')
@include('admin.assets.switchery')
@include('admin.assets.dropdown')
@include('admin.assets.delete_modal')
@include('admin.assets.sortable', ['selector' => '.sorted_table', 'id' => 'sorting_table', 'route' => route('subnavigation.reorder') ]);


