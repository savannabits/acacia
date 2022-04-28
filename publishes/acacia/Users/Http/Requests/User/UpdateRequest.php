<?php

namespace Acacia\Users\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\Users\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "name" => ["sometimes", "string"],
            "email" => [
                "sometimes",
                "email",
                Rule::unique("users", "email")->ignore(
                    $this->user->getKey(),
                    $this->user->getKeyName()
                ),
                "string",
            ],
            "email_verified_at" => ["nullable", "date"],
            "password" => [
                "sometimes",
                "confirmed",
                Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            "remember_token" => ["nullable", "string"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("update", $this->user);
    }

    public function sanitizedArray(): array
    {
        $sanitized = $this->validated();
        //Add your code for manipulation with request data here
        return $sanitized;
    }
    /**
     * Return modified (sanitized data) as a php object
     * @return  object
     */
    public function sanitizedObject(): object
    {
        return json_decode(collect($this->sanitizedArray()));
    }
}
