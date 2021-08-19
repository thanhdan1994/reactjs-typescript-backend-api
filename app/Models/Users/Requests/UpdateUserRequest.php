<?php
namespace App\Models\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description' => 'required',
            'title' => 'required'
        ];
    }
}
