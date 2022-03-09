<?php

namespace Savannabits\Acacia\Core;

use Illuminate\Support\HtmlString;

class FieldType
{
    private string $name;
    private HtmlString $formTemplate;
    private string $migrationTemplate;
    private string $formValidation = '';
    private string $httpValidation = '';
    private string $title;

    public function __construct(string $fieldType)
    {
    }

    /**
     * @param string $name
     * @return FieldType
     */
    public function setName(string $name): FieldType
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormTemplate(): string
    {
        return $this->formTemplate;
    }

    /**
     * @return string
     */
    public function getMigrationTemplate(): string
    {
        return $this->migrationTemplate;
    }

    /**
     * @param string $formValidation
     * @return FieldType
     */
    public function setFormValidation(string $formValidation): FieldType
    {
        $this->formValidation = $formValidation;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormValidation(): string
    {
        return $this->formValidation;
    }

    /**
     * @param string $httpValidation
     * @return FieldType
     */
    public function setHttpValidation(string $httpValidation): FieldType
    {
        $this->httpValidation = $httpValidation;
        return $this;
    }

    /**
     * @return string
     */
    public function getHttpValidation(): string
    {
        return $this->httpValidation;
    }

    /**
     * @param string $migrationTemplate
     */
    public function setMigrationTemplate(string $migrationTemplate): void
    {
        $this->migrationTemplate = $migrationTemplate;
    }

    /**
     * @param string $formTemplate
     */
    public function setFormTemplate(string $formTemplate): void
    {
        $this->formTemplate = $formTemplate;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}