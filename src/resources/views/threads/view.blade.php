@extends('liddleforum::layout')

@push(config('liddleforum.blade.stacks.head'))
<style>
	.liddleforum-post {
		padding: 10px;
		background-color: #f3f3f3;
		border-radius: 5px;
		color: #333;
		margin-bottom: 20px;
		position: relative;
	}

	.liddleforum-thread .thread-title {
		margin-bottom: 20px;
		font-weight: bold;
	}

	.liddleforum-thread .avatar {
		float: left;
		margin: 5px;
		margin-right: 15px;
		position: absolute;
		left: 10px;
	}

	.liddleforum-thread .avatar img {
		width: 60px;
		height: 60px;
		border-radius: 50%;
	}

	.liddleforum-thread .post-body {
		margin-left: 80px;
	}
</style>
@endpush

@section('liddleforum_content_inner')
	<div class="liddleforum-thread">

		<h4 class="pull-right">{{ \LiddleDev\LiddleForum\Helpers\GeneralHelper::getTimeAgo($thread->created_at) }}</h4>
		<p class="thread-title">
			<a href="{{ route('liddleforum.categories.view', ['category' => $thread->category->slug]) }}">{{ $thread->category->name }}</a> &gt; {{ $thread->title }}
		</p>

		@foreach($thread->posts as $post)
		<div class="liddleforum-post">
			<div class="avatar">
				<img src="{{ $avatar->getUrl($post->user) }}">
			</div>
			<div class="post-body">
				<span class="pull-right">{{ \LiddleDev\LiddleForum\Helpers\GeneralHelper::getTimeAgo($post->created_at) }}</span>
				<p><strong>{{ $post->user->{config('liddleforum.user.name_column')} }}</strong></p>
				<p>{{ $post->body }}</p>
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