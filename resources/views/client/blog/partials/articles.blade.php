<table class="table table-striped table-bordered table-responsive-md">
    <thead>
    <tr>
        <th>Meno</th>
        <th>Description</th>
        <th>Datum vytvoření</th>
        <th>Datum poslední změny</th>
        @if(\Auth::check() && \Auth::user()->isAdmin())
            <th></th>
        @endif
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
            @if(\Auth::check() && \Auth::user()->isAdmin())
            <td>
                <a href="{{ route('article.edit', ['article' => $article]) }}"><i class="fa fa-pencil"></i></a>
                <a href="#" onclick="event.preventDefault(); $('#article-delete-{{ $article->url }}').submit();"><i class="fa fa-trash"></i></a>

                <form action="{{ route('article.destroy', ['article' => $article]) }}" method="POST" id="article-delete-{{ $article->url }}" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </td>
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">
                {{ trans('general.empty.article') }}
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

@auth
    @if(isset($category))
        <a href="{{ route('article.category', ['category' => $category]) }}" class="btn btn-primary">
            {{ trans('general.adding.article') }}
        </a>
    @else
        <a href="{{ route('article.create') }}" class="btn btn-primary">
            {{ trans('general.adding.article') }}
        </a>
    @endif
@endauth
