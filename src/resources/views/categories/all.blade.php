@extends('liddleforum::layout')

@section('liddleforum_content_inner')

	<h3>All Categories</h3>

	@if(count($categories))
	<ul>
		@foreach($categories as $category)
			<li><a href="{{ route('liddleforum.categories.view', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
		@endforeach
	</ul>
	@endif

@endsection