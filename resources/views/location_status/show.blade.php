@extends('base')

@section('title', $status->name)
@section('description', $status->name)

@section('content')
    <main>
        <h1>{{ $status->name }}</h1>
    </main>
@endsection
