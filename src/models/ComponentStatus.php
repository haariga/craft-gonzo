<?php

namespace haariga\craftgonzo\models;

class ComponentStatus {
    /**
     * @var string Label of the Status
     */
    public string $label;
    /**
     * @var string Color of status badge, must be valid CSS value
     */
    public string $color;

    protected function __construct(string $label, string $color)
    {
        $this->label = $label;
        $this->color = $color;
    }

    public static function create(string $label = 'Ready', string $color = 'green'): static
    {
        return new self($label, $color);
    }

    public function getStatus(): ComponentStatus
    {
        return $this;
    }

    /**
     * @param string $label
     * @return ComponentStatus
     */
    public function setLabel(string $label): ComponentStatus
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $color
     * @return ComponentStatus
     */
    public function setColor(string $color): ComponentStatus
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }
}
