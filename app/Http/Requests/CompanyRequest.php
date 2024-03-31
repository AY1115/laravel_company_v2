<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            //
            "Com_Name" => ["required", "string", "max:255"],
            "Address" => ["required", "string", "max:255"],
            "Tel" => ["required", "string", "max:255"],
            "Name" => ["required", "string", "max:255"]
        ];
    }
}
