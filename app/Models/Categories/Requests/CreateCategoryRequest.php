<?php
namespace App\Models\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255']
        ];
    }
}
