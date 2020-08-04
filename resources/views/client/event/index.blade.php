@extends('layouts.client')

@section('title', 'Event')
@section('description', 'Event event.')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            @include('client.partials.form_errors')
            <h1>{{ trans('general.navbar.contact') }}</h1>

            <form action="{{ route('contact.send') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="email">{{ trans('general.contact.email') }}</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" placeholder="example@email.com" required />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="year">{{ trans('general.contact.year') }}</label>
                        <input type="number" name="year" id="year" class="form-control" placeholder="{{\Carbon\Carbon::now()->year}}" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="message">{{ trans('general.contact.message') }}</label>
                    <textarea name="message" id="message" rows="10" class="form-control" placeholder="Vasa sprava" required minlength="100">{{ old('message') }}</textarea>
                </div>


                <button type="submit" class="btn btn-primary">{{ trans('general.contact.send') }}</button>
            </form>
        </div>
    </div>
@endsection
