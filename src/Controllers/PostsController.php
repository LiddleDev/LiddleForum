<?php

namespace LiddleDev\LiddleForum\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LiddleDev\LiddleForum\Models\Post;
use LiddleDev\LiddleForum\Models\Thread;

class PostsController extends Controller
{
    public function postCreate(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        Post::create([
            'thread_id' => $thread->getKey(),
            'user_id' => \Auth::user()->getKey(),
            'body' => $request->input('body'),
        ]);

        $request->session()->flash('success', 'Your reply has been posted');

        return redirect()->route('liddleforum.threads.view', [
            'thread_slug' => $thread->slug,
        ]);
    }

    public function postEdit($thread_slug, $post_id)
    {
        if ( ! $post = $this->fetchPost($thread_slug, $post_id)) {
            abort(404);
        }

        // TODO
        return 'todo';
    }

    public function deletePost($thread_slug, $post_id)
    {
        if ( ! $post = $this->fetchPost($thread_slug, $post_id)) {
            abort(404);
        }

        // TODO
        return 'todo';
    }

    /**
     * @param $thread_slug
     * @return Thread|null
     */
    protected function fetchThread($thread_slug)
    {
        return Thread::where('slug', '=', $thread_slug)->first();
    }

    /**
     * @param $thread_slug
     * @param $post_id
     * @return Post|null
     */
    protected function fetchPost($thread_slug, $post_id)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            return null;
        }

        return $thread->posts()->where('id', '=', $post_id)->first();
    }
}