@extends('layouts.admin')

@section('content')

	<form action="{{ route('inventory.update', ['inventory' => $inventoryItem->id]) }}" class="form-horizontal"
		  method="post">
        @csrf
		@method('PUT')
		<div class="row">
			<div class="col-md-12">
				@include('admin.partials.form_errors')

				<div class="x_panel">
					<div class="x_title">
						<h2>Edit inventory item</h2>
						<div class="pull-right">
							<button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
							<a href="{{ route('inventory.index') }}" class="btn btn-danger"><i
										class="fa fa-times"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
                            <div class="form-group">
                                <label for="inventory_category_id" class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category_id" id="category_id"
                                            class="form-control">
                                        @foreach(\App\Models\Inventory\InventoryCategory::get() as $category)
                                            <option value="{{$category->id}}" {{$inventoryItem->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Inventory number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input1" name="inventory_id"
                                           value="{{$inventoryItem->inventory_id}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input1" class="col-sm-2 control-label">Serial number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="input1" name="serial_id"
                                           value="{{$inventoryItem->serial_id}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input2" class="col-sm-2 control-label">Location</label>
                                <div class="col-sm-10">
                                    <select name="location_id" id="input2" class="form-control">
                                        @foreach(\App\Models\Locations\Location::get() as $location)
                                            <option value="{{$location->id}}" {{$inventoryItem->location->id == $location->id ? 'selected':''}}>{{$location->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <ul class="nav nav-tabs" style="margin-bottom: 3%">
                                @foreach(\App\Models\Language\Language::all() as $language)
                                    <li class="{{($language->id==$inventoryItem->language->id ? "active":"")}}">
                                        <a href="#{{$language->id}}" data-toggle="tab">{{$language->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div id="myTabContent" class="tab-content">

                                @foreach(\App\Models\Language\Language::all() as $language)
                                    @php
                                        $item = \App\Models\Inventory\InventoryItem::where('id', $inventoryItem->id)->ofLang($language)->first();
                                    @endphp
                                    <div class="tab-pane fade {{$language->id== $inventoryItem->language->id ? "active":""}} in" id="{{$language->id}}">
                                        <div class="form-group">
                                            <label for="input1" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="input1" name="name-{{$language->id}}"
                                                       value="{{$item->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="note" class="col-sm-2 control-label">Note</label>
                                            <div class="col-sm-10">
										        <textarea name="note" id="note" class="form-control"
                                                  rows="3">{{$item->note}}</textarea>
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
	</form>

@endsection
