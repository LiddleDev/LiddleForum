<table class="table table-bordered" style="margin-bottom: 0;">
    <tbody>
    <tr>
        <td>
            <div class="form-group">
                <label for="category[{{ $currentCategory->id }}]['name']">Name</label>
                <input id="category[{{ $currentCategory->id }}]['name']" name="category[{{ $currentCategory->id }}]['name']" type="text" class="form-control" value="{{ $currentCategory->name }}" />
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="category[{{ $currentCategory->id }}]['slug']">Slug</label>
                <input id="category[{{ $currentCategory->id }}]['slug']" name="category[{{ $currentCategory->id }}]['slug']" type="text" class="form-control" value="{{ $currentCategory->slug }}" />
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="category[{{ $currentCategory->id }}]['order']">Order</label>
                <input id="category[{{ $currentCategory->id }}]['order']" name="category[{{ $currentCategory->id }}]['order']" type="text" class="form-control" value="{{ $currentCategory->order }}" />
            </div>
        </td>
        @if($currentCategory->parent_id)
            <td>
                <div class="form-group">
                    <label for="category[{{ $currentCategory->id }}]['parent_id']">Parent Category</label>
                        <select id="category[{{ $currentCategory->id }}]['parent_id']" name="category[{{ $currentCategory->id }}]['parent_id']" class="form-control">
                            @foreach($categories as $category)
                                @if($category->id === $currentCategory->id)
                                    @continue
                                @endif
                                <option value="{{ $category->id }}" @if($currentCategory->parent_id === $category->id) selected @endif>{{ $category->getDropdownName() }}</option>
                            @endforeach
                        </select>
                </div>
            </td>
            <td class="text-center" style="vertical-align: middle;">
                <p><strong>{{ $currentCategory->threads()->count() }}</strong> threads</p>
            </td>
        @else
            <td class="text-center" style="vertical-align: middle;">
                <p><em>Base Category cannot be moved</em></p>
            </td>
        @endif
    </tr>
    @if(count($currentCategory->subcategories))
        <tr>
            <td colspan="{{ $currentCategory->parent_id ? 5 : 4 }}" style="padding: 0 0 0 50px; background-color: {{ $categoryColors[$categoryColorCount++ % count($categoryColors)] }};">
                @foreach($currentCategory->subcategories as $subcategory)
                    @include('liddleforum::admin.categories.partials.category_table', ['currentCategory' => $subcategory])
                @endforeach
            </td>
        </tr>
    @endif
    </tbody>
</table>