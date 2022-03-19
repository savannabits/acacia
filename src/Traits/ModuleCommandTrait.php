<?php

namespace Savannabits\Acacia\Traits;

trait ModuleCommandTrait
{
    /**
     * Get the module name.
     *
     * @return string
     */
    public function getModuleName()
    {
        $module = $this->argument('module') ?: app('modules')->getUsedNow();

        $module = app('modules')->findOrFail($module);

        return $module->getStudlyName();
    }

    public function getSpecialModules(): array {
        return [
            "Users",
            "Roles",
            "Permissions"
        ];
    }
    public function isSpecial(): bool
    {
        return in_array($this->getModuleName(),$this->getSpecialModules());
    }
    public function deriveSpecialStub($baseStub): string
    {
        $specialName = \Str::slug($this->getModuleName());
        return $this->isSpecial() ? "/$baseStub.$specialName.stub" : "/$baseStub.stub";
    }
}
