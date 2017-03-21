<?php

namespace LiddleDev\LiddleForum\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LiddleDev\LiddleForum\Models\Post;
use LiddleDev\LiddleForum\Models\Thread;
use HTMLPurifier;

class PostsController extends Controller
{
    /**
     * @var HTMLPurifier
     */
    private $htmlPurifier;

    public function __construct(HTMLPurifier $htmlPurifier)
    {

        $this->htmlPurifier = $htmlPurifier;
    }

    public function postCreate(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('reply', $thread)) {
            abort(403);
        }

        $body = $request->input('body');
        $body = $this->htmlPurifier->purify($body);

        Post::create([
            'thread_id' => $thread->getKey(),
            'user_id' => \Auth::user()->getKey(),
            'body' => $body,
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

        if (Gate::denies('edit', $post)) {
            abort(403);
        }

        // TODO
        return 'todo';
    }

    public function deletePost(Request $request, $thread_slug, $post_id)
    {
        if ( ! $post = $this->fetchPost($thread_slug, $post_id)) {
            abort(404);
        }

        if (Gate::denies('delete', $post)) {
            abort(403);
        }

        $thread = $post->thread;

        $post->delete();

        $request->session()->flash('success', 'Post has been deleted');
        return redirect()->route('liddleforum.threads.view', ['slug' => $thread->slug]);
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