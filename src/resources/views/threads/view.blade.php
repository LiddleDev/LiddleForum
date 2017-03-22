@extends('liddleforum::layout')

@push(config('liddleforum.blade.stacks.head'))
{!! $textEditor->headerIncludes() !!}
@endpush

@section('liddleforum_content_inner')
	<div class="liddleforum-thread">

		@can('update', $thread)
			@can('lock', $thread)
				<div class="pull-right" style="margin-left: 4px;">
					<form method="POST" action="{{ route('liddleforum.threads.' . ($thread->locked ? 'unlock' : 'lock'), ['thread_slug' => $thread->slug]) }}">
						{!! csrf_field() !!}
						<button class="btn btn-warning btn-sm"><i class="fa fa-fw fa-lock"></i> {{ $thread->locked ? 'Unlock' : 'Lock' }}</button>
					</form>
				</div>
			@endcan
			@can('sticky', $thread)
				<div class="pull-right" style="margin-left: 4px;">
					<form method="POST" action="{{ route('liddleforum.threads.' . ($thread->stickied ? 'unsticky' : 'sticky'), ['thread_slug' => $thread->slug]) }}">
						{!! csrf_field() !!}
						<button class="btn btn-warning btn-sm"><i class="fa fa-fw fa-sticky-note"></i> {{ $thread->stickied ? 'Unsticky' : 'Sticky' }}</button>
					</form>
				</div>
			@endcan
			@can('delete', $thread)
				<div class="pull-right" style="margin-left: 4px;">
					<form method="POST" action="{{ route('liddleforum.threads.delete', ['thread_slug' => $thread->slug]) }}">
						{!! method_field('DELETE') !!}
						{!! csrf_field() !!}
						<button class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
					</form>
				</div>
			@endcan
			@can('edit', $thread)
				<a href="{{ route('liddleforum.threads.edit', ['thread_slug' => $thread->slug]) }}" class="btn btn-info btn-sm pull-right" style="margin-left: 4px;">
					<i class="fa fa-fw fa-edit"></i> Edit
				</a>
			@endcan
			<div class="clearfix visible-xs" style="margin-bottom: 10px;"></div>
		@endcan
		<p class="thread-title">
			<a href="{{ route('liddleforum.index') }}">Home</a> &gt;
			@foreach($thread->category->getCategoryChain() as $parentCategory)
				<a href="{{ route('liddleforum.categories.view', ['category' => $parentCategory->slug]) }}">{{ $parentCategory->name }}</a> &gt;
			@endforeach
			<a href="{{ route('liddleforum.categories.view', ['category' => $thread->category->slug]) }}">{{ $thread->category->name }}</a> &gt; {{ $thread->title }}
		</p>

		@foreach($thread->posts as $post)
		<div class="liddleforum-post">
			<div class="liddleforum-avatar">
				<img src="{{ $avatar->getUrl($post->user) }}">
			</div>
			<div class="post-body">
				<span class="pull-right">{{ \LiddleDev\LiddleForum\Helpers\GeneralHelper::getTimeAgo($post->created_at) }}</span>
				<p><strong>{{ $post->user->{config('liddleforum.user.name_column')} }}</strong></p>
				{!! $post->body !!}
				@can('update', $post)
					<div class="clearfix"></div>
					<hr>
					@can('edit', $post)
						<a href="{{ route('liddleforum.threads.posts.edit', ['thread_slug' => $thread->slug, 'post_id' => $post->id]) }}" class="btn btn-info btn-sm">
							<i class="fa fa-fw fa-edit"></i> Edit
						</a>
					@endcan
					@can('delete', $post)
						<form style="display: inline-block;" method="POST" action="{{ route('liddleforum.threads.posts.delete', ['thread_slug' => $thread->slug, 'post_id' => $post->id]) }}">
							<input type="hidden" name="_method" value="DELETE">
							{!! csrf_field() !!}
							<button class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
						</form>
					@endcan
				@endcan
			</div>
		</div>
		@endforeach

		@can('reply', $thread)
			<div class="liddleforum-reply">
				<form method="POST" action="{{ route('liddleforum.threads.posts.create', ['thread_slug' => $thread->slug]) }}">
					{!! csrf_field() !!}

					<div class="form-group">
						<label for="liddleforum-reply-body">Reply</label>
						<textarea id="liddleforum-reply-body" name="body" class="form-control" placeholder="Enter your reply here..."></textarea>
					</div>

					<button class="btn btn-primary">Reply</button>

				</form>
			</div>
		@else
			<hr>
			<div class="text-center alert alert-warning">
				<p>
					<i class="fa fa-fw fa-warning"></i>
					@if($thread->locked)
						You cannot reply to this thread because it has been locked
					@elseif( ! Auth::check())
						Please sign in to reply to this thread
					@else
						You do not have permission to reply to this thread
					@endif
				</p>
			</div>
		@endcan

	</div>

@endsection

@push(config('liddleforum.blade.stacks.footer'))
{!! $textEditor->footerIncludes() !!}
<script>
	{!! $textEditor->applyToTextArea('liddleforum-reply-body') !!}
</script>
@endpush