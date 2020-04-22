@extends('layouts.admin')

@section('content')

    <form action="{{ route('inventory.category.store')}}" class="form-horizontal" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create inventory category</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('inventory.category.index') }} " class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-6">
                                <ul class="nav nav-tabs" style="margin-bottom: 3%">
                                    @foreach(\App\Language::all() as $language)
                                        <li class="{{($language->id==1 ? "active":"")}}">
                                            <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    @foreach(\App\Language::all() as $lang)
                                        <div class="tab-pane fade {{($lang->id==1 ? "active":"")}} in" id="{{$lang->id}}">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="content">Name:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name-{{$lang->id}}" class="form-control" value="{{ old('name-' .$lang->id)}}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
