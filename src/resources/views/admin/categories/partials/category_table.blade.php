<table class="table table-bordered" style="margin-bottom: 0;">
    <tbody>
    <tr>
        <td>
            <div class="form-group">
                <label for="categories[{{ $currentCategory->id }}][name]">Name</label>
                <input id="categories[{{ $currentCategory->id }}][name]" name="categories[{{ $currentCategory->id }}][name]" type="text" class="form-control" value="{{ old('categories.' . $currentCategory->id . '.name', $currentCategory->name) }}" />
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="categories[{{ $currentCategory->id }}][slug]">Slug</label>
                <input id="categories[{{ $currentCategory->id }}][slug]" name="categories[{{ $currentCategory->id }}][slug]" type="text" class="form-control" value="{{ old('categories.' . $currentCategory->id . '.slug', $currentCategory->slug) }}" />
            </div>
        </td>
        <td>
            <div class="form-group">
                <label for="categories[{{ $currentCategory->id }}][order]">Order</label>
                <input id="categories[{{ $currentCategory->id }}][order]" name="categories[{{ $currentCategory->id }}][order]" type="text" class="form-control" value="{{ old('categories.' . $currentCategory->id . '.order', $currentCategory->order) }}" />
            </div>
        </td>
        @if($currentCategory->parent_id)
            <td>
                <div class="form-group">
                    <label for="categories[{{ $currentCategory->id }}][parent_id]">Parent Category</label>
                        <select id="categories[{{ $currentCategory->id }}][parent_id]" name="categories[{{ $currentCategory->id }}][parent_id]" class="form-control">
                            @foreach($currentCategory->getPossibleParentCategories() as $category)
                                @if($category->id === $currentCategory->id)
                                    @continue
                                @endif
                                <option value="{{ $category->id }}" @if(old('categories.' . $currentCategory->id . '.parent_id', $currentCategory->parent_id) === $category->id) selected @endif>{{ $category->getDropdownName() }}</option>
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