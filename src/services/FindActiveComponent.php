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
     * @return mixed|null
     */
    public function findActiveComponent(string $slug)
    {
        if (empty($slug)) {
            return null;
        }
        // /_components/accordion/accordion
        $tree = CraftGonzo::getInstance()->templatesFolder->getTemplates();
        $collection = collect($tree);
        $dots = collect(mb_split('/', $slug));
        $last = $dots->pop();
        $walker = $dots->map(function ($item) use($dots) {
            if ($item == $dots->last()) return ['item' => $item];
            return ['item' => $item, 'children' => 'children'];
        })->flatten();
        $dots = implode('.', $walker->all());
        $walking = collect([$collection])->pluck($dots);
        $activeComponent = collect($walking->first()['configs'])->filter(function($config) use ($slug){
            return $config['config']->getSlug() == '/' . $slug;
        });

        $this->setActiveComponent($activeComponent->first());
        return $activeComponent->first();

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
