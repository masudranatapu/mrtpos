<?php

namespace App\Http\Requests\BackendRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            "name" => ["required", "max:30", "min:3", "string"],
            "email" => ["nullable", "max:30", "min:3", "string"],
            "phone" => ["required", "regex:/^[0-9]+$/", "max:15"],
            "image" => ["nullable", "max:10240", "mimes:jpeg,png,jpg,webp", "image"],
            "gender" => [
                "nullable",
                Rule::in(['Male', 'Female'])
            ],
            "member_ship_id" => ["nullable", "string"],
            "date_of_birth" => ["nullable"],
            "due" => ["nullable", "min:0"],
            "customer_group_id" => [
                "nullable",
                "numeric",
                Rule::exists('customer_groups', 'id')
            ],
            "date" => "nullable",
            "area" => [
                "nullable",
                "string",
                Rule::exists('areas', 'id')
            ],
            "zip_code" => ["nullable", "numeric"],
            "address" => ["nullable", "string", "min:3", "max:50"],
            "sorting_number" => ["nullable", "numeric", "min:1", "max:11"],
            "note" => ["nullable", "string", "min:3", "max:200"],
        ];
    }
}
