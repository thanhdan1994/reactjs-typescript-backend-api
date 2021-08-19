<?php
namespace App\Models\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'excerpt' => 'required',
            'name' => 'required'
        ];
    }
}
