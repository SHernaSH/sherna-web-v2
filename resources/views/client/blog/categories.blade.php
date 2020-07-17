@extends('layouts.client')

@section('title', 'Seznam článků')
@section('description', 'Výpis všech článků v administraci.')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-12 toCollapse">
        @forelse($categories as $category)
            <h2 data-toggle="collapse" data-parent="#inventory-items" class="collapsed"
                href="#collapse{{$category->id}}" aria-expanded="true"
                aria-controls="collapse{{$category->id}}">
                {{$category->detail->name}}
                <i class="fa fa-chevron-circle-down cursor"></i>
            </h2>
            <div class="collapse" id="collapse{{$category->id}}">
                <div class="col-md-12 m-4">
                    @include('client.blog.partials.articles', [
                                'articles' => $category->articles()->public()->paginate(),
                                'category' => $category->detail->name,
                                ])
                </div>
            </div>
        @empty
            <p>{{ trans('general.empty.category') }}</p>
        @endforelse
        @if(\Auth::check() && \Auth::user()->isAdmin())
            <a href="{{ route('category.create') }}" class="btn btn-primary mt-3">
                {{trans('general.adding.category')}}
            </a>
        @endif
    </div>
    </div>
@endsection


