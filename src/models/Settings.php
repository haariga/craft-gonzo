<?php

namespace haariga\craftgonzo\models;

use craft\config\BaseConfig;

class Settings extends BaseConfig
{
    /**
     * @var array Folder to search for components
     */
    public array $compFolders = [];
    /**
     * @var string Layoutfile used to render components
     */
    public string $layoutFile = '/_layouts/patternlib.twig';
    /**
     * @var array Config Instances for components, only these are rendered at the end,
     */
    public array $comps = [];
    /**
     * @var array Sizes for media query buttons
     */
    public array $mqButtons = [];

    /**
     * @var string Default Comp Status Key
     */
    public string $defaultCompStatus = 'wip';
    /**
     * @var array Possible states a component can have
     */
    public array $compStatus = [];
    /**
     * @var array Define pages
     */
    public array $pages = [];

    /**
     * @var array If defined the Sidebar structure is used from this array, it can be multidimensional
     */
    public array $structure;

    public function init(): void
    {
        $this->compStatus([
            'ready' => ComponentStatus::create()->setColor('green')->setLabel('Ready'),
            'wip' => ComponentStatus::create()->setColor('yellow')->setLabel('WIP'),
            'prototype' => ComponentStatus::create()->setColor('orange')->setLabel('Prototype')
        ]);
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function rules(): array
    {
        return [
            [['compFolders',], 'required'],
            ['compStatus', ComponentStatus::class],
        ];
    }

    /**
     * @param array $compFolders
     *
     * @return Settings
     */
    public function compFolders(array $compFolders): Settings
    {
        $this->compFolders = $compFolders;
        return $this;
    }

    /**
     * @param string $layoutFile
     *
     * @return Settings
     */
    public function layoutFile(string $layoutFile): Settings
    {
        $this->layoutFile = $layoutFile;
        return $this;
    }

    /**
     * @param array $comps
     *
     * @return Settings
     */
    public function comps(array $comps): Settings
    {
        $this->comps = $comps;
        return $this;
    }

    /**
     * @param array $mqButtons
     *
     * @return Settings
     */
    public function mqButtons(array $mqButtons): Settings
    {
        $this->mqButtons = $mqButtons;
        return $this;
    }

    /**
     * @param array $compStatus
     *
     * @return Settings
     */
    public function compStatus(array $compStatus): Settings
    {
        $this->compStatus = $compStatus;
        return $this;
    }

    /**
     * @param array $pages
     *
     * @return Settings
     */
    public function pages(array $pages): Settings
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @param array $structure
     *
     * @return Settings
     */
    public function setStructure(array $structure): Settings
    {
        $this->structure = $structure;
        return $this;
    }
}
