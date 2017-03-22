<?php

namespace LiddleDev\LiddleForum\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LiddleDev\LiddleForum\Drivers\Avatar\AvatarInterface;
use LiddleDev\LiddleForum\Drivers\TextEditor\TextEditorInterface;
use LiddleDev\LiddleForum\Helpers\ThreadHelper;
use LiddleDev\LiddleForum\Models\Category;
use LiddleDev\LiddleForum\Models\Post;
use LiddleDev\LiddleForum\Models\Thread;
use HTMLPurifier;


class ThreadsController extends Controller
{
    /**
     * @var AvatarInterface
     */
    private $avatar;

    /**
     * @var TextEditorInterface
     */
    private $textEditor;

    /**
     * @var HTMLPurifier
     */
    private $htmlPurifier;

    public function __construct(AvatarInterface $avatar, TextEditorInterface $textEditor, HTMLPurifier $htmlPurifier)
    {
        $this->avatar = $avatar;
        $this->textEditor = $textEditor;
        $this->htmlPurifier = $htmlPurifier;
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

        $slug = ThreadHelper::generateSlug($request->input('title'));

        $thread = Thread::create([
            'title' => $request->input('title'),
            'category_id' => $category->id,
            'user_id' => \Auth::user()->getKey(),
            'slug' => $slug,
        ]);

        $body = $request->input('body');
        $body = $this->htmlPurifier->purify($body);

        $post = $thread->posts()->create([
            'user_id' => \Auth::user()->getKey(),
            'body' => $body,
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

        if (Gate::denies('edit', $thread)) {
            abort(403);
        }

        return view('liddleforum::threads.edit', [
            'thread' => $thread,
        ]);
    }

    public function postEdit(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('edit', $thread)) {
            abort(403);
        }

        $slug = ThreadHelper::generateSlug($request->input('title'));

        $thread->update([
            'title' => $request->input('title'),
            'slug' => $slug,
        ]);

        $request->session()->flash('success', 'Thread has been saved');

        return redirect()->route('liddleforum.threads.view', [
            'thread_slug' => $thread->slug,
        ]);
    }

    public function deleteThread(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('delete', $thread)) {
            abort(403);
        }

        $category = $thread->category;

        $thread->delete();

        $request->session()->flash('success', 'Thread has been deleted');
        return redirect()->route('liddleforum.categories.view', ['category' => $category->slug]);
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