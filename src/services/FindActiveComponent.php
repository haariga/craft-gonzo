<?php

namespace haariga\craftgonzo\services;

use craft\base\Component;
use haariga\craftgonzo\models\ComponentConfig;

class FindActiveComponent extends Component
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function findActiveComponent(array $tree, string $slug)
    {
        if (empty($slug)) {
            return null;
        }
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

        return $activeComponent->first();
    }
}
