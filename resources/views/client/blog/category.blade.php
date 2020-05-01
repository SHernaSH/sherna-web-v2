@extends('layouts.client')

@section('title', 'Seznam článků')
@section('description', 'Výpis všech článků v administraci.')

@section('content')
    <div class="row">
        <h2>{{ $category->name }}</h2>
        <div class="col-md-6 col-md-offset-3 col-xs-12">
            <table class="table table-striped table-bordered table-responsive-md">
                <thead>
                <tr>
                    <th>Meno</th>
                    <th>Datum vytvoření</th>
                    <th>Datum poslední změny</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>
                            <a href="{{ route('blog.show', ['article' => $article]) }}">
                                {{ $article->text->title }}
                            </a>
                        </td>
                        <td>{{ $article->text->description }}</td>
                        <td>{{ $article->created_at->isoFormat('LLL') }}</td>
                        <td>{{ $article->updated_at->isoFormat('LLL') }}</td>
                        <td>
                            <a href="{{ route('article.edit', ['article' => $article]) }}">Editovat</a>
                            <a href="#" onclick="event.preventDefault(); $('#article-delete-{{ $article->url }}').submit();">Odstranit</a>

                            <form action="{{ route('article.destroy', ['article' => $article]) }}" method="POST" id="article-delete-{{ $article->url }}" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Nikdo zatím nevytvořil žádný článek.
                        </td>
                    </tr>
                @endforelse
                @if($articles->hasPages())
                    <tr>
                        <td class="text-center" colspan="5">{{ $articles->links() }}</td>
                    </tr>
                @endif
                </tbody>
            </table>

        </div>
    </div>
@endsection
