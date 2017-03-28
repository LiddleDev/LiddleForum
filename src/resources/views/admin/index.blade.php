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
						<th width="1%">ID</th>
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
							<th width="1%">ID</th>
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

	<h3>Categories</h3>
	<p>Customise the categories to be shown on your forum</p>

@endsection