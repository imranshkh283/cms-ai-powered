<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\HttpResponse;
use App\Enums\ArticleStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateStatusRequest extends FormRequest
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
            'id' => ['required', 'integer'],
            'status'        => ['required', new Enum(ArticleStatus::class)],
            'published_at' => [
                'nullable',
                'date',
                Rule::requiredIf(fn() => $this->status === ArticleStatus::Published->value),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Id is required.',
            'id.integer' => 'Id must be an integer.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be one of Draft, Published, Archived.',
            'published_at.nullable' => 'Published_at is required.',
            'published_at.date' => 'Published_at must be a valid date.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->validationError($validator->errors())
        );
    }
}
