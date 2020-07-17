@extends('layouts.admin')

@section('content')

    <form action="{{ route('game.store') }}" class="form-horizontal" method="post">
        @csrf

        <div class="row">
            <div class="col-md-12">
                @include('admin.partials.form_errors')

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create game</h2>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i></button>
                            <a href="{{ route('game.index') }}" class="btn btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="name" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input2" class="col-sm-4 control-label">Max possible players</label>
                                    <div class="col-sm-8">
                                        <input type="number" min="1" class="form-control" id="input2" name="possible_players" value="{{old('possible_players')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Inventory number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="inventory_id"
                                               value="{{old('inventory_id')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input1" class="col-sm-4 control-label">Serial number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="input1" name="serial_id"
                                               value="{{old('serial_id')}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="note" class="col-sm-4 control-label">Note</label>
                                    <div class="col-sm-8">
										<textarea name="note" id="note" class="form-control"
                                                  rows="3">{{old('note')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                        <label for="vr" class="col-sm-2 control-label">VR</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="vr" value="0">
                                            <input type="checkbox" class="js-switch" name="vr"
                                                   value="1">
                                            </div>
                                </div>

                                <div class="form-group">
                                    <label for="vr" class="col-sm-2 control-label">Kinect</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="kinect" value="0">
                                        <input type="checkbox" name="kinect" class="js-switch"
                                               value="1">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vr" class="col-sm-2 control-label">Game Pad</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="game_pad" value="0">
                                            <input type="checkbox" name="game_pad" class="js-switch"
                                        value="1">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vr" class="col-sm-2 control-label">Move/Aim</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="move" value="0">
                                        <input type="checkbox" name="move" class="js-switch"
                                               value="1">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="vr" class="col-sm-2 control-label">Guitar</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" name="guitar" value="0">
                                        <input type="checkbox" name="guitar" class="js-switch"
                                               value="1">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="input2" class="col-sm-2 control-label">Console</label>
                                    <div class="col-sm-8">
                                        <select name="console_id" id="input2" class="form-control">
                                            @foreach(\App\Models\Consoles\Console::get() as $console)
                                                <option value="{{$console->id}}">{{$console->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@include('admin.assets.switchery')
