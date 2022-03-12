<?php

namespace Acacia\AcaciaRelationships\Http\Requests\Relationship;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\AcaciaRelationships\Models\Relationship;
class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "type" => [],
            "method" => [],
            "related_key" => [],
            "related_table" => [],
            "local_key" => [],
            "label_column" => [],
            "is_recursive" => [],
            "is_morph" => [],
            "morph_type_column" => [],
            "morph_id_column" => [],
            "server_validation" => [],
            "in_list" => [],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("viewAny", Relationship::class);
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
