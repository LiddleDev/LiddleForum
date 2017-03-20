@extends('liddleforum::layout')

@push(config('liddleforum.blade.stacks.head'))
<style>
	.subcategory-title {
		font-size: 1.3em;
	}

	.category-list .subcategory-table td {
		vertical-align: middle;
	}

	.category-list .subcategory-table td p {
		vertical-align: middle;
		margin-bottom: 0;
	}
</style>
@endpush

@section('liddleforum_content_inner')

	<div class="category-list">
	@foreach($categories as $category)
		<div class="panel panel-default category-item">
			<div class="panel-heading" style="{{ $category->color ? 'background-color: #' . $category->color . ';' : '' }}">
				<span class="panel-title category-title">{{ $category->name }}</span>
			</div>
			<table class="table table-striped table-bordered subcategory-table">
				<thead>
				<tr>
					<th>Board</th>
					<th width="10%" class="hidden-xs">Threads</th>
					<th width="10%" class="hidden-xs">Posts</th>
					<th width="30%" class="hidden-xs hidden-sm">Last Post</th>
				</tr>
				</thead>
				<tbody>
				@foreach($category->subcategories as $subcategory)
					<tr>
						<td>
							<p class="subcategory-title">
								<a href="{{ route('liddleforum.categories.view', ['category' => $subcategory->slug]) }}">{{ $subcategory->name }}</a>
							</p>
							<p class="subcategory-description">{{ $subcategory->description }}</p>
						</td>
						<td class="text-center hidden-xs">{{ $subcategory->threads()->count() }}</td>
						<td class="text-center hidden-xs">{{ $subcategory->posts()->count() }}</td>
						<?php $mostRecentPost = $subcategory->getMostRecentPost(); ?>
						<td class="text-right hidden-xs hidden-sm">
							@if ($mostRecentPost)
								<p>
									<a href="{{ route('liddleforum.threads.view', ['thread_slug' => $mostRecentPost->thread->slug]) }}">
										{{ str_limit($mostRecentPost->thread->title, 40) }}
									</a>
								</p>
								<p>
									<small>
										by {{ $mostRecentPost->user->{config('liddleforum.user.name_column')} }}
										- {{ \LiddleDev\LiddleForum\Helpers\GeneralHelper::getTimeAgo($mostRecentPost->created_at) }}
									</small>
								</p>
							@else
								<p>-</p>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	@endforeach
	</div>

@endsection