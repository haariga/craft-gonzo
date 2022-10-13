<?php

namespace haariga\craftgonzo\models;

class ComponentConfig extends ComponentData
{
    public bool $visible = true;
    public string $templatePath = '';
    private string $path = '';
    public string $slug = '';

    /**
     * @var ComponentVariant[]
     */
    public array $variants = [];

    /**
     * @return ComponentVariant[]
     */
    public function getVariants(): array
    {
        return $this->variants;
    }

    public function getDefaultVariant(): ComponentVariant
    {
        return $this->variants[0];
    }

    /**
     * @param ComponentVariant[] $variants
     */
    public function setVariants(array $variants): void
    {
        $this->variants = $variants;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * @param string $templatePath
     */
    public function setTemplatePath(string $templatePath): void
    {
        $this->templatePath = $templatePath;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}
