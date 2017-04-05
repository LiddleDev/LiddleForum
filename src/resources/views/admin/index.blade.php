@extends('liddleforum::layout')

@section('liddleforum_content_inner')

	<h3>Users</h3>
	<p>Manage your admins and moderators here. Note that if you create other admin accounts, they can remove you as an admin</p>

	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Admins</h3>
				</div>

				<table class="table table-striped table-bordered">
					<thead>
					<tr>
						<th width="1%">User ID</th>
						<th>Name</th>
						<th width="1%">Actions</th>
					</tr>
					</thead>
					<tbody>
					@foreach($admins as $admin)
					<tr>
						<td>{{ $admin->user->getKey() }}</td>
						<td>{{ $admin->user->{config('liddleforum.user.name_column')} }}</td>
						<td>
							<button class="btn btn-danger btn-sm">Remove</button>
						</td>
					</tr>
					@endforeach
					</tbody>
				</table>

				<div class="panel-footer">

					<form>
						<div class="form-group">
							<label for="user_id">User ID</label>
							<input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="{{ old('user_id', Request::get('user_id')) }}" />
						</div>

						<button class="btn btn-sm btn-success">Add Admin</button>
					</form>

				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Moderators</h3>
				</div>

				@if(count($moderators))

					<table class="table table-striped table-bordered">
						<thead>
						<tr>
							<th width="1%">User ID</th>
							<th>Name</th>
							<th>Category</th>
							<th width="1%">Actions</th>
						</tr>
						</thead>
						<tbody>
						@foreach($moderators as $moderator)
							<tr>
								<td>{{ $moderator->user->getKey() }}</td>
								<td>{{ $moderator->user->{config('liddleforum.user.name_column')} }}</td>
								<td>
									@if($moderator->category)
										{{ $moderator->category->name }}</td>
									@else
										<strong>Global</strong>
									@endif
								<td>
									<button class="btn btn-danger btn-sm">Remove</button>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>

				@else

					<div class="panel-body">
						There are currently no moderators, add them below.
					</div>

				@endif

				<div class="panel-footer">
					<form>
						<div class="form-group">
							<label for="user_id">User ID</label>
							<input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="{{ old('user_id', Request::get('user_id')) }}" />
						</div>

						<div class="form-group">
							<label for="category">Category</label>
							<select id="category" name="category" class="form-control">
								<option value="">- Global -</option>
								@foreach($categories as $category)
									<option value="{{ $category->slug }}" @if(old('category', Request::get('category')) === $category->slug) selected @endif>{{ $category->getDropdownName() }}</option>
								@endforeach
							</select>
						</div>

						<button class="btn btn-sm btn-success">Add Mod</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<h3>Create Category</h3>
	<p>Create a new category or subcategory</p>


	<form>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" id="name" name="name" class="form-control" />
		</div>

		<div class="form-group">
			<label for="slug">Slug</label>
			<input type="text" id="slug" name="slug" class="form-control" />
		</div>

		<div class="form-group">
			<label for="category">Category</label>
			<select id="category" name="category" class="form-control">
				<option value="">Base Category</option>
				@if(count($categories))
					<option disabled="disabled">----------------------------</option>
					@foreach($categories as $category)
						<option value="{{ $category->id }}">{{ $category->getDropdownName() }}</option>
					@endforeach
				@endif
			</select>
		</div>

		<button class="btn btn-success">Create Category</button>
	</form>

	<hr>

	<h3>Edit Categories</h3>
	<p>Customise the categories to be shown on your forum</p>

	@if(count($baseCategories))
		<form>
			<?php
				$categoryColors = [
					'#eeccbb',
					'#cceebb',
					'#bbccee',
					'#ff88aa',
				];
				$categoryColorCount = 0;
			?>
			@foreach($baseCategories as $baseCategory)
				@include('liddleforum::admin.partials.category_table', ['currentCategory' => $baseCategory])
			@endforeach

			<button class="btn btn-primary" style="margin-top: 20px;">Update Categories</button>
		</form>
	@else
		<div class="alert alert-info">
			<i class="fa fa-fw fa-info-circle"></i> You do not have any categories yet
		</div>
	@endif

	<hr>

	<h3>Delete Category</h3>
	<p>
		Delete an existing category or subcategory.
		<strong>This will delete all subcategories and their threads belonging to the deleted category!</strong>
		<strong>This cannot be undone!</strong>
	</p>

	@if(count($categories))
		<form>
			<div class="form-group">
				<label for="category">Category</label>
				<select id="category" name="category" class="form-control">
					<option value="">- Please Select -</option>
					@foreach($categories as $category)
						<option value="{{ $category->id }}">{{ $category->getDropdownName() }}</option>
					@endforeach
				</select>
			</div>

			<button class="btn btn-danger">Delete Category</button>
		</form>
	@else
		<div class="alert alert-info">
			<i class="fa fa-fw fa-info-circle"></i> You do not have any categories yet
		</div>
	@endif

@endsection



















