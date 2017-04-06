@extends('liddleforum::layout')

@section('liddleforum_content_inner')

    @include('liddleforum::admin.partials.tabs')

    <h3>Create Category</h3>
    <p>Create a new category or subcategory</p>

    <ul>
        <li><p><strong>Name:</strong> The category name to show on your forum.</p></li>
        <li><p><strong>Slug:</strong> The identifying part of the URL. For example a slug of <em>"introductions"</em> would be used like <em>"domain.com/forums/categories/introductions"</em>. Please note that slugs have to be unique!</p></li>
        <li><p><strong>Order:</strong> The order that you would like this category to be displayed inside the parent category. The lower the number, the earlier it will show.</p></li>
        <li><p><strong>Parent Category:</strong> Select which category you would like this subcategory to appear in. Or, make this a base category.</p></li>
    </ul>

    <hr>

    @include('liddleforum::flashed.form_errors')

    <form method="POST" action="{{ route('liddleforum.admin.categories.create') }}">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" />
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="order">
                        Order<small> - (Edit existing orders <a target="_blank" href="{{ route('liddleforum.admin.categories.edit') }}">here</a>)</small>
                    </label>
                    <input type="text" id="order" name="order" class="form-control" value="{{ old('order') }}" />
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="parent_id">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value="">None - Make this a Base Category</option>
                        @if(count($categories))
                            <option disabled="disabled">----------------------------</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"{{ old('parent_id') === $category->id ? ' selected' : '' }}>{{ $category->getDropdownName() }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
        <button class="btn btn-success">Create Category</button>
    </form>

@endsection