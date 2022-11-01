<?php

namespace haariga\craftgonzo\models;

use haariga\craftgonzo\services\GetStatus;

abstract class ComponentData
{
    public string $uuid = '';
    public string $title = '';
    public ComponentStatus $status;
    public string $description = '';
    public string $fileIdentifier = '';
    public bool $visible = true;



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
    public function setStatus(string|ComponentStatus $status): void
    {
        if ($status instanceof ComponentStatus) {
            $findStatus = GetStatus::instance()->getStatus($status->getLabel());
        } else {
            $findStatus = GetStatus::instance()->getStatus($status);
        }
        $this->status = $findStatus;
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

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
}
