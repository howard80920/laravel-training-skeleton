<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursorPaginateRequest extends FormRequest
{
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
            'cursor'   => ['nullable'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'per_page' => intval($this->input('per_page') ?? 1),
        ]);
    }

}
