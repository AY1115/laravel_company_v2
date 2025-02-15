<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
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
            "B_Name" => ["required", "string", "max:255"],
            "B_Address" => ["required", "string", "max:255"],
            "B_Tel" => ["required", "string", "max:255"],
            "B_Dapart" => ["required", "string", "max:255"],
            "B_AddName" => ["required", "string", "max:255"]
        ];
    }
}
