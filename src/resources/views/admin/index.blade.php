@extends('liddleforum::layout')

@section('liddleforum_content_inner')

	<h3>Users</h3>
	<a href="{{ route('liddleforum.admin.admins.index') }}" class="btn btn-primary btn-lg">Admins</a>
	<a href="{{ route('liddleforum.admin.moderators.index') }}" class="btn btn-primary btn-lg">Moderators</a>

	<hr>

	<h3>Categories</h3>
	<a href="{{ route('liddleforum.admin.categories.create') }}" class="btn btn-primary btn-lg">Create Category</a>
	<a href="{{ route('liddleforum.admin.categories.edit') }}" class="btn btn-primary btn-lg">Edit Categories</a>
	<a href="{{ route('liddleforum.admin.categories.delete') }}" class="btn btn-primary btn-lg">Delete Category</a>

@endsection