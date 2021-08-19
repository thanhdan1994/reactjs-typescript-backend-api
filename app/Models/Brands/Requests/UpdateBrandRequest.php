<?php
namespace App\Models\Brands\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:255']
        ];
    }
}
