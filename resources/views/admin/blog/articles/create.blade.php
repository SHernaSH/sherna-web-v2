@extends('layouts.admin')



@section('content')

    <form action="{{ route('article.store')}}" class="form-horizontal" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create article</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('article.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="url">Url:</label>
                            <div class="col-sm-10">
                                <input type="text" id="url" name="url" class="form-control" value="{{ old('url') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="tags">Categories:</label>
                            <div class="col-sm-10">
                                <input name="tags" value="{{ old('tags', $category) }}" id="tags"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="comments">Enable comments:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="comments" name="comments" class="js-switch" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="public">Make public:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="public" name="public" class="js-switch" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="public">Share to Facebook:</label>
                            <div class="col-sm-10">
                                <input type="checkbox" id="public" name="public" checked class="js-switch" />
                            </div>
                        </div>

                        <ul class="nav nav-tabs" style="margin-bottom: 3%">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <li class="{{($language->id==1 ? "active":"")}}">
                                    <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <div class="tab-pane fade {{$language->id==1 ? "active":""}} in" id="{{$language->id}}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="name-{{$language->id}}">Name:</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="name-{{$language->id}}" name="name-{{$language->id}}" class="form-control" value="{{ old('name-' . $language->id) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="description-{{$language->id}}">Description:</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="description-{{$language->id}}" name="description-{{$language->id}}" class="form-control" value="{{ old('description-' . $language->id) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="content">Content:</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" id="content-{{$language->id}}" name="content-{{$language->id}}" value="{{ old('content-' . $language->id) }}" class="input-info" data-langID="{{$language->id}}">
                                            <div class="summernote" data-langID="{{$language->id}}">

                                            </div>
                                        </div>
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

@include('admin.assets.jq_ui')
@include('admin.assets.summernote')
@include('admin.assets.switchery')
@include('admin.assets.tags')
