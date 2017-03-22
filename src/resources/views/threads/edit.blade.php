@extends('liddleforum::layout')

@section('liddleforum_content_inner')

	<h3>Edit Thread</h3>

	<form method="POST" action="{{ route('liddleforum.threads.edit', ['thread_slug' => $thread->slug]) }}">
		{!! csrf_field() !!}

		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ $thread->title }}">
		</div>

		<button class="btn btn-primary">Save</button>

	</form>
@endsection