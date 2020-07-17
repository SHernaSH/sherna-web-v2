@extends('layouts.admin')

@section('content')

    <form action="{{ route('inventory.category.update', ['category' => $inventoryCategory->id])}}" class="form-horizontal" method="post">
        @csrf
        @method('PUT')
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
                                    @foreach(\App\Models\Language\Language::all() as $language)
                                        <li class="{{($language->id==$inventoryCategory->language->id ? "active":"")}}">
                                            <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    @foreach(\App\Models\Language\Language::all() as $lang)
                                        @php
                                        $category = \App\Models\Inventory\InventoryCategory::where('id', $inventoryCategory->id)->ofLang($lang)->first();
                                        @endphp
                                        <div class="tab-pane fade {{($lang->id==$inventoryCategory->language->id ? "active":"")}} in" id="{{$lang->id}}">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="content">Name:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="name-{{$lang->id}}" class="form-control" value="{{$category->name}}">
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
