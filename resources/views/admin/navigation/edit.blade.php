@extends('layouts.admin')

@php
    $is_dropdown = session()->get( 'is_dropdown', false ) || !empty(old('dropdown')) || $navigation->dropdown;
@endphp
@section('content')

    <form action="{{ route('navigation.update', ['navigation' => $navigation->id])}}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <input type="hidden" name="url" id="url">
                        <h2>Edit navigation</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('navigation.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

{{--                        <div class="form-group">--}}
{{--                            <label class="col-sm-2 control-label" for="order">Order:</label>--}}
{{--                            <div class="col-sm-10">--}}
{{--                                <input name="order" id="order" type="number" min="1" value="{{ old('order', $navigation->order) }}" required/>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="url">Is dropdown:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="dropdown" id="dropdown" class="js-switch js-check-change"
                                    {{$is_dropdown ? "checked" : "" }} />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="public">Make public:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="public" id="public" {{$navigation->public || old('is_public') || old('public') ? "checked" : ""}} class="js-switch" />
                            </div>
                        </div>

                        @include('admin.assets.modal.modal-form', ['title' => 'Subpage'])


                        <ul class="nav nav-tabs" style="margin-bottom: 3%">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <li class="{{($language->id==$navigation->language->id ? "active":"")}}">
                                    <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                @php
                                    $nav = \App\Models\Navigation\Page::where('id', $navigation->id)->ofLang($language)->first();
                                @endphp
                                <div class=" tab-pane fade {{($language->id==$navigation->language->id ? "active":"")}} in" id="{{$language->id}}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="name-{{$language->id}}">Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="name-{{$language->id}}" name="name-{{$language->id}}" class="form-control" value="{{ $nav->name ?: old('name-' . $language->id) }}">
                                        </div>
                                    </div>
                                    <div class="not_dropdown {{$is_dropdown ? "d-none" : ""}}" >

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="content-{{$language->id}}">Content:</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" id="content-{{$language->id}}" name="content-{{$language->id}}"
                                                       value="{{ $navigation->text ? $navigation->text()->ofLang($language)->first()->content : old('content-' . $language->id) }}" class="input-info" data-langID="{{$language->id}}">
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


