<?php

namespace Acacia\AcaciaMenus\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\AcaciaMenus\Models\Menu;
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
            "title" => ["required", "string"],
            "icon" => ["nullable", "string"],
            "route" => ["nullable", "string"],
            "url" => ["nullable", "string"],
            "active_pattern" => ["nullable", "string"],
            "position" => ["nullable", "integer"],
            "permission_name" => ["nullable", "string"],
            "module_name" => ["nullable", "string"],
            "description" => ["nullable", "string"],
            "parent" => ["nullable", "array"],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("create", Menu::class);
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
