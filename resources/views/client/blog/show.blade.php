@extends('layouts.client')

@section('title', $article->text->title)
@section('description', $article->text->description)

<style>
    .display-comment .display-comment {
        margin-left: 40px
    }
</style>

@section('content')
    <div class="container">
        <div class="row pb-5">
            <div class="col-md-12 col-xs-12">
                <main>
                    <article class="article">
                        <header>
                            <h1 class="display-4 mb-0">{{ $article->text->title }}</h1>
                        </header>

                        <div class="article-content">{!! $article->text->content !!}</div>

                        <footer>
                            <p class="small text-secondary border-top pt-2 mt-4"><i class="fa fa-calendar"></i>
                                                            {{ $article->text->updated_at->diffForHumans() }}
                            </p>
                        </footer>
                    </article>
                </main>
            </div>
        </div>

        <div class="row">
               <div class="col-md-10 col-md-offset-1 col-xs-10">
                    <h4>{{ trans('comment.comments') }}</h4>
                   @if($article->comments_enabled)
                   @forelse($article->comments as $comment)
                    <div class="display-comment">
                        <div class="grid grid-pad">
                            <div class="col-md-2 col-xs-2">
                                <i class="fa fa-fw fa-users"></i>
                                <img src="{{ $comment->user->image }}" class="" alt="">
                            </div>
                            <div class="col-md-10 col-xs-10 comment comment-radius">
                                <strong>{{ $comment->user->name }}</strong>
                                <p>{{ $comment->body }}</p>
                            </div>
                            <div class="text-right">{{ $comment->updated_at->diffForHumans() }}</div>
                        </div>
                        @include('client.blog.partials.comments.reply_partial', ['comment' => $comment, 'article_id' => $article->id])
                        @include('client.blog.partials.comments.nested_comment_partial', ['comments' => $comment->replies,
                         'article_id' => $article->id, 'depth' => 1])
                    </div>
                    @empty
                        @auth
                            <div class="text-center">
                                <h4>{{ trans('comment.no_comment') }}</h4>
                            </div>
                        @endauth
                    @endforelse
                    @auth
                        <form method="post" class="md-form mt-5" action="{{ route('comment.store', ['article' => $article]) }}">
                            @csrf
                            <div class="form-group">
                                <textarea  name="comment_body" class="form-control comment-radius"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-warning" value="{{ trans('comment.add') }}" />
                            </div>
                        </form>
                    @else
                        <div class="text-center">
                            <h4>{{ trans('comment.login') }}</h4>
                        </div>
                    @endauth
                   @else
                       <h3>{{ trans('comment.disabled') }}</h3>
                   @endif
               </div>
        </div>
    </div>
@endsection
