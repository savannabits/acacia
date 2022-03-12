<?php

namespace Acacia\AcaciaRelationships\Http\Requests\Relationship;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\AcaciaRelationships\Models\Relationship;
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
            "type" => ["required", "string"],
            "method" => ["required", "string"],
            "related_key" => ["nullable", "string"],
            "related_table" => ["nullable", "string"],
            "local_key" => ["nullable", "string"],
            "label_column" => ["nullable", "string"],
            "is_recursive" => ["required", "boolean"],
            "is_morph" => ["required", "boolean"],
            "morph_type_column" => ["nullable", "string"],
            "morph_id_column" => ["nullable", "string"],
            "server_validation" => ["nullable", "string"],
            "in_list" => ["required", "boolean"],
            "related" => ["nullable", "array"],
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
        return $this->user()->can("create", Relationship::class);
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
