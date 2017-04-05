@extends('liddleforum::layout')

@section('liddleforum_content_inner')

    <h3>Create Category</h3>
    <p>Create a new category or subcategory</p>

    <form method="POST" action="{{ route('liddleforum.admin.categories.create') }}">
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" />
        </div>

        <div class="form-group">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control" />
        </div>

        <div class="form-group">
            <label for="category">Parent Category</label>
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

@endsection