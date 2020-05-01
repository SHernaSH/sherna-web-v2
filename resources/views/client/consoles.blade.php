@foreach($consoles as $console)
    <option value="{{$console->id}}">{{$console->name}}</option>
@endforeach