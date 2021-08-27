<?php
namespace App\Models\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'featured_image' => 'required',
            'unit' => 'required',
        ];
    }
}
