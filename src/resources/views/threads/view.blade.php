@extends('liddleforum::layout')

@push(config('liddleforum.blade.stacks.head'))
<script src="//cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'#liddleforum-reply-body' });</script>
@endpush

@section('liddleforum_content_inner')
	<div class="liddleforum-thread">

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
			</div>
		</div>
		@endforeach

		<div class="liddleforum-reply">
			<form method="POST" action="{{ route('liddleforum.threads.posts.create', ['thread_slug' => $thread->slug]) }}">
				{!! csrf_field() !!}

				<div class="form-group">
					<label for="body">Reply</label>
					<textarea id="body" name="body" class="form-control" placeholder="Enter your reply here..."></textarea>
				</div>

				<button class="btn btn-primary">Submit Reply</button>

			</form>
		</div>

	</div>


@endsection