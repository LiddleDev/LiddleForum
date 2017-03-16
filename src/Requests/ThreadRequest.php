<?php

namespace LiddleDev\LiddleForum\Requests;

use Illuminate\Http\Request;
use LiddleDev\LiddleForum\Models\Category;

class ThreadRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $categoryObject = new Category();

        return [
            'title' => 'required',
            'category' => 'required|exists:' . $categoryObject->getTable() . ',slug',
            'body' => 'required',
        ];
    }
}