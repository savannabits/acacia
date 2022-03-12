<?php

namespace Acacia\AcaciaMenus\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Acacia\AcaciaMenus\Models\Menu;
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
            "icon" => [],
            "route" => [],
            "url" => [],
            "active_pattern" => [],
            "position" => [],
            "permission_name" => [],
            "module_name" => [],
            "description" => [],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can("viewAny", Menu::class);
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
