<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\HttpResponse;

class UpdateArticleRequest extends FormRequest
{
    use HttpResponse;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3|max:65535',
            'categories' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.min' => 'Title must be at least 3 characters.',
            'title.max' => 'Title must be at most 255 characters.',
            'title.string' => 'Title must be a string.',
            'content.required' => 'Content is required.',
            'content.min' => 'Content must be at least 3 characters.',
            'content.max' => 'Content must be at most 65535 characters.',
            'content.string' => 'Content must be a string.',
            'categories.required' => 'Categories is required.',
            'categories.array' => 'Categories must be an array.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->validationError($validator->errors())
        );
    }
}
