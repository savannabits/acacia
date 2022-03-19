<?php

namespace Acacia\AcaciaFields\Http\Requests\Field;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\AcaciaFields\Models\Field;
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
            "title" => [],
            "name" => [],
            "description" => [],
            "db_type" => [],
            "html_type" => [],
            "server_validation" => [],
            "client_validation" => [],
            "is_vue" => [],
            "has_options" => [],
            "is_guarded" => [],
            "is_hidden" => [],
            "in_form" => [],
            "in_list" => [],
            "options_route_name" => [],
            "options_label_field" => [],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("viewAny", Field::class);
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
