<ul class="nav nav-pills">
    <li role="presentation"{!! Route::currentRouteName() === 'liddleforum.admin.admins.index' ? ' class="active"' : '' !!}><a href="{{ route('liddleforum.admin.admins.index') }}">Admins</a></li>
    <li role="presentation"{!! Route::currentRouteName() === 'liddleforum.admin.moderators.index' ? ' class="active"' : '' !!}><a href="{{ route('liddleforum.admin.moderators.index') }}">Moderators</a></li>
    <li role="presentation"{!! Route::currentRouteName() === 'liddleforum.admin.categories.create' ? ' class="active"' : '' !!}><a href="{{ route('liddleforum.admin.categories.create') }}">Create Category</a></li>
    <li role="presentation"{!! Route::currentRouteName() === 'liddleforum.admin.categories.edit' ? ' class="active"' : '' !!}><a href="{{ route('liddleforum.admin.categories.edit') }}">Edit Categories</a></li>
    <li role="presentation"{!! Route::currentRouteName() === 'liddleforum.admin.categories.delete' ? ' class="active"' : '' !!}><a href="{{ route('liddleforum.admin.categories.delete') }}">Delete Category</a></li>
</ul>

<hr>