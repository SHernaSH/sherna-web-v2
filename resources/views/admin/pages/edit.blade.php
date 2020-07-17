@extends('layouts.admin')

@section('styles')
    <link href="{{asset('summernote/summernote.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('content')

    <form action="{{ route('page.update', ['page' => $page->id, 'type' => $type]) }}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit page</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ redirect()->back() }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <ul class="nav nav-tabs" style="margin-bottom: 3%">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                <li class="{{($language->id==$page->language->id ? "active":"")}}">
                                    <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            @foreach(\App\Models\Language\Language::all() as $language)
                                @php
                                    $text = $page->text()->ofLang($language)->first();
                                @endphp
                                <div class=" tab-pane fade {{($language->id==$page->language->id ? "active":"")}} in" id="{{$language->id}}">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="name-{{$language->id}}">Name:</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="name-{{$language->id}}" name="name-{{$language->id}}" class="form-control"
                                                       value="{{ old('name-' . $language->id, $text->title) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="content-{{$language->id}}">Content:</label>
                                            <div class="col-sm-10">
                                                <input type="hidden" id="content-{{$language->id}}" name="content-{{$language->id}}"
                                                       value="{{ old('content-' . $language->id, $text->content) }}" class="input-info" data-langID="{{$language->id}}">
                                                <div class="summernote" data-langID="{{$language->id}}">

                                                </div>
                                            </div>
                                        </div>
                                </div>
                            @endforeach
                        </div>
                        @if(isset($page->special_code))
                             @include('admin.pages.special_pages.'. $page->special_code)
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@include('admin.assets.summernote')
