<?php

namespace haariga\craftgonzo\services;

use craft\base\Component;
use haariga\craftgonzo\CraftGonzo;
use haariga\craftgonzo\helpers\ActiveComponent;
use haariga\craftgonzo\models\ComponentConfig;

class FindActiveComponent extends Component
{
    private $activeComponent;

    /**
     * @param string $slug
     *
     * @return mixed
     */
    public function findActiveComponent(string $slug)
    {
        $components = collect(CraftGonzo::getInstance()->templatesFolder->getComponentsArray());
        $components = $components->filter(function ($item) use ($slug) {
            $componentSlug = $item['config']->getSlug();
            $slug = preg_quote($slug, '/');
            $pattern = "/$slug/i";
            return preg_match($pattern, $componentSlug);
        });

        $this->setActiveComponent($components->first());

        return $components->first();
    }

    /**
     * @return mixed
     */
    public function getActiveComponent()
    {
        return $this->activeComponent;
    }

    /**
     * @param mixed $activeComponent
     */
    public function setActiveComponent($activeComponent): void
    {
        $this->activeComponent = $activeComponent;
    }
}
