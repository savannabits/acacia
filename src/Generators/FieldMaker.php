<?php

namespace Savannabits\Acacia\Generators;

use Acacia\Core\Constants\FormFields;
use Acacia\Core\Models\Field;
use Savannabits\Acacia\Support\Stub;

class FieldMaker
{
    public function __construct(private Field $field)
    {
    }

    public function renderForShow(): string
    {
        $replacements = [
            "LABEL" => $this->field->title,
            "MODEL_FIELD" => "model?.".$this->field->name,
        ];
        if ($this->field->html_type === FormFields::SELECT) {
            $replacements["RELATIONSHIP_METHOD"] =\Str::snake($this->field->name);
            $replacements["RELATIONSHIP_LABEL"] =$this->field->options_label_field ?? 'id';
            $replacements["MODEL_FIELD"] = "model?.".$replacements["RELATIONSHIP_METHOD"]."?.".$replacements["RELATIONSHIP_LABEL"];
        }
        $stub = match ($this->field->html_type) {
            FormFields::SWITCH, FormFields::CHECKBOX => "boolean",
            FormFields::SELECT      => 'relationship',
            FormFields::DATE        => 'date',
            FormFields::DATETIME    => 'datetime',
            default => "default",
        };
        return (new Stub("/js/pages/show-fields/$stub.stub",$replacements))->render();
    }
    public function render(): string
    {
        $replacements = [
            "LABEL" => $this->field->title,
            "V_MODEL" => "form.".$this->field->name,
        ];
        if ($this->field->html_type ===FormFields::SELECT) {
            $replacements["OPTIONS_ROUTE"] =$this->field->options_route_name;
            $replacements["OPTIONS_LABEL"] =$this->field->options_label_field ?? 'id';
        }
        $stub = match ($this->field->html_type) {
            FormFields::SWITCH => "switch",
            FormFields::CHECKBOX => "checkbox",
            FormFields::AUTOCOMPLETE => 'autocomplete',
            FormFields::TEXTAREA => 'textarea',
            FormFields::PASSWORD => 'password',
            FormFields::MASK => 'mask',
            FormFields::SELECT => 'rich-select',
            FormFields::DATE => 'date',
            FormFields::DATETIME => 'datetime',
            default => "text",
        };
        return (new Stub("/js/pages/fields/$stub.stub",$replacements))->render();
    }

    public function getComponentImport() {
        return match ($this->field->html_type) {
            FormFields::SWITCH => 'import InputSwitch from "primevue/inputswitch";',
            FormFields::AUTOCOMPLETE => 'import AutoComplete from "primevue/autocomplete";',
            FormFields::TEXT => 'import InputText from "primevue/inputtext";',
            FormFields::CHECKBOX => "import Checkbox from 'primevue/checkbox';",
            FormFields::PASSWORD => "import Password from 'primevue/password';",
            FormFields::MASK => "import InputMask from 'primevue/inputmask';",
            FormFields::TEXTAREA => "import Textarea from 'primevue/textarea';",
            FormFields::SELECT => "import AcaciaRichSelect from '@/Components/AcaciaRichSelect.vue';",
            FormFields::DATETIME, FormFields::DATE => "import AcaciaDatepicker from '@/Components/AcaciaDatepicker.vue';",
            default => null,
        };
    }
}
