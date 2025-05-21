<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\HttpResponse;

class CategoryRequest extends FormRequest
{
    use HttpResponse;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:categories',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.unique' => 'Name must be unique.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.max' => 'Name must be at most 255 characters.',
            'name.string' => 'Name must be a string.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->validationError($validator->errors())
        );
    }
}
