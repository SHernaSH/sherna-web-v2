
<form action="{{ route('active.store') }}" enctype="multipart/form-data"s method="POST">
    @csrf
    <div>
        @foreach(\App\Models\Language\Language::all() as $language)
            <input type="hidden" name="name-{{ $language->id }}" value="{{ $name[$language->id] }}">
        @endforeach
            <input type="hidden" name="is_public" value="{{$is_public}}">

            <div class="form-group">
            <label for="sub_name">Name</label>
            <input type="text" name="sub_name" id="sub_name" class="form-control" value="{{ old('sub_name') }}"/>
            </div>

            <div class="form-group">
                <label for="sub_nickname">Nick name</label>
                <input type="text" name="sub_nickname" id="sub_nickname" class="form-control" value="{{ old('sub_nickname') }}"/>
            </div>

            <div class="form-group">
                <label for="sub_email">Email</label>
                <input type="text" name="sub_email" id="sub_email" class="form-control" value="{{ old('sub_email') }}"/>
            </div>
            <div class="form-group">
                <label for="sub_room">Room</label>
                <input type="text" name="sub_room" id="sub_room" class="form-control" value="{{ old('sub_room') }}"/>
            </div>

            <div class="form-group">
                <label for="file">Photo</label>
                <input type="file" accept="image/*" name="file" id="file" class="form-control" value="{{ old('sub_photo') }}"/>
            </div>

            <div class="form-group">
                <label for="sub_public">Is public</label>
                <input type="checkbox" class="js-switch" name="sub_public" id="sub_public" class="form-control" {{( !empty(old('sub_public'))) ? "checked" : "" }} />
            </div>

            <button type="submit" class="btn btn-primary">Add active member</button>
        </div>
</form>
@include('admin.assets.summernote_modal')

