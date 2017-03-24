@extends('liddleforum::layout')

@push(config('liddleforum.blade.stacks.head'))
{!! $textEditor->headerIncludes() !!}
@endpush

@section('liddleforum_content_inner')

    <p class="thread-title">
        <a href="{{ route('liddleforum.index') }}">Home</a>
    </p>

    <h3>Create Thread</h3>

    @include('liddleforum::flashed.form_errors')

    <form method="POST" action="{{ route('liddleforum.threads.create') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @if(old('category', Request::get('category')) === $category->slug) selected @endif>{{ $category->getDropdownName() }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title', Request::get('title')) }}" />
        </div>

        <div class="form-group">
            <label for="liddleforum-reply-body">Message</label>
            <textarea id="liddleforum-reply-body" name="body" class="form-control" placeholder="Enter your thread message here..."></textarea>
        </div>

        <button class="btn btn-primary">Create Thread</button>

    </form>
@endsection

@push(config('liddleforum.blade.stacks.footer'))
{!! $textEditor->footerIncludes() !!}
<script>
    {!! $textEditor->applyToTextArea('liddleforum-reply-body') !!}
</script>
@endpush