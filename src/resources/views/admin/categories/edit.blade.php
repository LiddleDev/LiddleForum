@extends('liddleforum::layout')

@section('liddleforum_content_inner')

    @include('liddleforum::admin.partials.tabs')

    <h3>Edit Categories</h3>
    <p>Customise the categories to be shown on your forum</p>

    <ul>
        <li><p><strong>Name:</strong> The category name to show on your forum.</p></li>
        <li><p><strong>Slug:</strong> The identifying part of the URL. For example a slug of <em>"introductions"</em> would be used like <em>"domain.com/forums/categories/introductions"</em>. Please note that slugs have to be unique!</p></li>
        <li><p><strong>Order:</strong> The order that you would like this category to be displayed inside the parent category. The lower the number, the earlier it will show.</p></li>
        <li><p><strong>Parent Category:</strong> Select which category you would like this subcategory to appear in. Base categories cannot become subcategories and subcategories cannot become base categories. This is because base categories cannot have threads.</p></li>
    </ul>

    @if(count($baseCategories))
        <form method="POST" action="{{ route('liddleforum.admin.categories.edit') }}">
            <?php
            $categoryColors = ['#eeccbb', '#cceebb', '#bbccee', '#ff88aa'];
            $categoryColorCount = 0;
            ?>
            @foreach($baseCategories as $baseCategory)
                @include('liddleforum::admin.categories.partials.category_table', ['currentCategory' => $baseCategory])
            @endforeach

            <button class="btn btn-primary" style="margin-top: 20px;">Update Categories</button>
        </form>
    @else
        <div class="alert alert-info">
            <i class="fa fa-fw fa-info-circle"></i> You do not have any categories yet
        </div>
    @endif

@endsection