<?php

namespace Acacia\AcaciaFields\Http\Requests\Field;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\AcaciaFields\Models\Field;
class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "title" => ["nullable", "string"],
            "name" => ["required", "string"],
            "description" => ["nullable", "string"],
            "db_type" => ["nullable", "string"],
            "html_type" => ["nullable", "string"],
            "server_validation" => ["nullable", "string"],
            "client_validation" => ["nullable", "string"],
            "is_vue" => ["required", "boolean"],
            "has_options" => ["required", "boolean"],
            "is_guarded" => ["required", "boolean"],
            "is_hidden" => ["required", "boolean"],
            "in_form" => ["required", "boolean"],
            "in_list" => ["required", "boolean"],
            "options_route_name" => ["nullable", "string"],
            "options_label_field" => ["nullable", "string"],
            "schematic" => ["required", "array"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("create", Field::class);
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
