<?php
namespace App\Models\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required',
            'excerpt' => 'required',
            'content' => 'required',
            'featured_image' => 'required',
        ];
    }
}
