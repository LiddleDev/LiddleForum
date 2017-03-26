<?php

namespace LiddleDev\LiddleForum\Controllers;

use Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LiddleDev\LiddleForum\Drivers\Avatar\AvatarInterface;
use LiddleDev\LiddleForum\Drivers\TextEditor\TextEditorInterface;
use LiddleDev\LiddleForum\Helpers\ThreadHelper;
use LiddleDev\LiddleForum\Models\Category;
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
        $thread = new Thread();

        if (Gate::denies('create', $thread)) {
            abort(403);
        }

        $categoryObject = new Category();

        $validator = Validator::make($request->all(), [
            'category' => 'required|exists:' . $categoryObject->getTable() . ',slug',
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('liddleforum.threads.create')
                ->withErrors($validator, 'liddleforum')
                ->withInput();
        }

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

        $thread->followers()->create([
            'user_id' => \Auth::user()->getKey(),
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

        $posts = $thread->posts()->with('user')->orderBy('created_at')->paginate(config('liddleforum.paginate.posts', 10));

        $followingThread = \Auth::check() && (bool)$thread->followers()->where('user_id', '=', \Auth::user()->getKey())->first();

        return view('liddleforum::threads.view', [
            'thread' => $thread,
            'posts' => $posts,
            'avatar' => $this->avatar,
            'followingThread' => $followingThread,
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

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('liddleforum.threads.edit', ['thread_slug' => $thread_slug])
                ->withErrors($validator, 'liddleforum')
                ->withInput();
        }

        $slug = ThreadHelper::generateSlug($request->input('title'));

        $thread->update([
            'title' => $request->input('title'),
            'slug' => $slug,
        ]);

        $request->session()->flash('liddleforum_success', 'Your thread has been saved');

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

        $request->session()->flash('liddleforum_success', 'Your thread has been deleted');
        return redirect()->route('liddleforum.categories.view', ['category' => $category->slug]);
    }

    public function postLock(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('lock', $thread)) {
            abort(403);
        }

        $thread->locked = 1;
        $thread->save();

        $request->session()->flash('liddleforum_success', 'Thread has been locked');
        return redirect()->route('liddleforum.threads.view', ['thread_slug' => $thread->slug]);
    }

    public function postUnlock(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('lock', $thread)) {
            abort(403);
        }

        $thread->locked = 0;
        $thread->save();

        $request->session()->flash('liddleforum_success', 'Thread has been unlocked');
        return redirect()->route('liddleforum.threads.view', ['thread_slug' => $thread->slug]);
    }

    public function postSticky(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('sticky', $thread)) {
            abort(403);
        }

        $thread->stickied = 1;
        $thread->save();

        $request->session()->flash('liddleforum_success', 'Thread has been stickied');
        return redirect()->route('liddleforum.threads.view', ['thread_slug' => $thread->slug]);
    }

    public function postUnsticky(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('sticky', $thread)) {
            abort(403);
        }

        $thread->stickied = 0;
        $thread->save();

        $request->session()->flash('liddleforum_success', 'Thread has been unstickied');
        return redirect()->route('liddleforum.threads.view', ['thread_slug' => $thread->slug]);
    }

    public function postFollow(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('follow', $thread)) {
            abort(403);
        }

        if ( ! $thread->followers()->where('user_id', '=', \Auth::user()->getKey())->first()) {
            $thread->followers()->create([
                'user_id' => \Auth::user()->getKey(),
            ]);
        }

        $request->session()->flash('liddleforum_success', 'You are now following this thread');
        return redirect()->route('liddleforum.threads.view', ['thread_slug' => $thread->slug]);
    }

    public function postUnfollow(Request $request, $thread_slug)
    {
        if ( ! $thread = $this->fetchThread($thread_slug)) {
            abort(404);
        }

        if (Gate::denies('follow', $thread)) {
            abort(403);
        }

        $thread->followers()->where('user_id', '=', \Auth::user()->getKey())->delete();

        $request->session()->flash('liddleforum_success', 'You have stopped following this thread');
        return redirect()->route('liddleforum.threads.view', ['thread_slug' => $thread->slug]);
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