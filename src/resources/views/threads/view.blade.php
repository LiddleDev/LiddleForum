@extends('liddleforum::layout')

@push(config('liddleforum.blade.stacks.head'))
{!! $textEditor->headerIncludes() !!}
@endpush

@section('liddleforum_content_inner')
	<div class="liddleforum-thread">

		@can('update', $thread)
			@can('sticky', $thread)
				<a href="#" class="btn btn-warning btn-sm pull-right" style="margin-left: 4px;">Sticky</a>
			@endcan
			@can('delete', $thread)
				<a href="#" class="btn btn-danger btn-sm pull-right" style="margin-left: 4px;">Delete</a>
			@endcan
			@can('edit', $thread)
				<a href="#" class="btn btn-info btn-sm pull-right" style="margin-left: 4px;">Edit</a>
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
						<a href="#" class="btn btn-info btn-sm">Edit</a>
					@endcan
					@can('delete', $post)
						<a href="#" class="btn btn-danger btn-sm">Delete</a>
					@endcan
				@endcan
			</div>
		</div>
		@endforeach

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

	</div>

@endsection

@push(config('liddleforum.blade.stacks.footer'))
{!! $textEditor->footerIncludes() !!}
<script>
	{!! $textEditor->applyToTextArea('liddleforum-reply-body') !!}
</script>
@endpush