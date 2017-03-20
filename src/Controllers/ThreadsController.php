<?php

namespace LiddleDev\LiddleForum\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LiddleDev\LiddleForum\Drivers\Avatar\AvatarInterface;
use LiddleDev\LiddleForum\Drivers\TextEditor\TextEditorInterface;
use LiddleDev\LiddleForum\Helpers\ThreadHelper;
use LiddleDev\LiddleForum\Models\Category;
use LiddleDev\LiddleForum\Models\Post;
use LiddleDev\LiddleForum\Models\Thread;


class ThreadsController extends Controller
{
    /**
     * @var ThreadHelper
     */
    private $threadHelper;

    /**
     * @var AvatarInterface
     */
    private $avatar;

    /**
     * @var TextEditorInterface
     */
    private $textEditor;

    public function __construct(ThreadHelper $threadHelper, AvatarInterface $avatar, TextEditorInterface $textEditor)
    {
        $this->threadHelper = $threadHelper;
        $this->avatar = $avatar;
        $this->textEditor = $textEditor;
    }

    public function getCreate()
    {
        $categories = Category::orderBy('parent_id')->whereNotNull('parent_id')->get();

        return view('liddleforum::threads.create', [
            'categories' => $categories,
            'textEditor' => $this->textEditor,
        ]);
    }

    public function postCreate(Request $request)
    {
        $category = Category::where('slug', '=', $request->input('category'))->first();

        $slug = $this->threadHelper->generateSlug($request->input('title'));

        $thread = Thread::create([
            'title' => $request->input('title'),
            'category_id' => $category->id,
            'user_id' => \Auth::user()->getKey(),
            'slug' => $slug,
        ]);

        $post = $thread->posts()->create([
            'user_id' => \Auth::user()->getKey(),
            'body' => $request->input('body'),
        ]);

        $request->session()->flash('liddleforum_success', 'Your thread has been created');

        return redirect()->route('liddleforum.threads.view', [
            'thread_slug' => $thread->slug,
        ]);
    }

    public function getThread($thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        $posts = $thread->posts()->with('user')->orderBy('created_at')->paginate(config('liddleforum.per_page'));

        return view('liddleforum::threads.view', [
            'thread' => $thread,
            'posts' => $posts,
            'avatar' => $this->avatar,
            'textEditor' => $this->textEditor,
        ]);
    }

    public function getEdit($thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        return view('liddleforum::threads.edit', [
            'thread' => $thread,
        ]);
    }

    public function postEdit($thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        // TODO
        return view('liddleforum::threads.edit');
    }

    public function deleteThread($thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
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
}