<?php

namespace haariga\craftgonzo\models;

abstract class ComponentData
{
    public string $title = '';
    public string $status = '';
    public string $description = '';
    public string $fileIdentifier = '';

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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
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
    public function getFileIdentifier(): string
    {
        return $this->fileIdentifier;
    }

    /**
     * @param string $fileIdentifier
     */
    public function setFileIdentifier(string $fileIdentifier): void
    {
        $this->fileIdentifier = $fileIdentifier;
    }
}
