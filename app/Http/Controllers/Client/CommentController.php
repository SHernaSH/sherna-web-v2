<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Articles\Article;
use App\Models\Comments\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{

    public function __construct()
    {
//        return $this->middleware('auth');
    }


    /**
     * Store a newly created top level Comment in storage.
     *
     * @param Request $request request with the comment data
     * @param Article $article
     * @return RedirectResponse redirect back to the article page
     */
    public function store(Request $request, Article $article)
    {
        $comment = new Comment();
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());

        $article->comments()->save($comment);
        $comment->save();
        return redirect()->back();//(route('blog.show', ['article' => $article]));
    }

    /**
     * Store a newly created reply level Comment in storage
     * and associate it with the parent comment
     *
     * @param Request $request  request with the comment data
     * @return RedirectResponse redirect back to the article page
     */
    public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $article = Article::find($request->get('article_id'));
        $article->comments()->save($reply);
        $reply->save();
        return redirect()->back(); //(route('blog.show', ['article' => $article]));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Comment $comment
     * @return Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
