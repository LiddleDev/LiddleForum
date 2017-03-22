@extends('liddleforum::layout')

@push(config('liddleforum.blade.stacks.head'))
{!! $textEditor->headerIncludes() !!}
@endpush

@section('liddleforum_content_inner')

	<h3>Edit Post in thread: <strong>{{ $thread->title }}</strong></h3>

	<form method="POST" action="{{ route('liddleforum.threads.posts.edit', ['thread_slug' => $thread->slug, 'post_id' => $post->id]) }}">
		{!! csrf_field() !!}

		<div class="form-group">
			<label for="liddleforum-reply-body">Message</label>
			<textarea id="liddleforum-reply-body" name="body" class="form-control" placeholder="Enter your thread message here...">{{ $post->body }}</textarea>
		</div>

		<button class="btn btn-primary">Save</button>

	</form>
@endsection

@push(config('liddleforum.blade.stacks.footer'))
{!! $textEditor->footerIncludes() !!}
<script>
	{!! $textEditor->applyToTextArea('liddleforum-reply-body') !!}
</script>
@endpush