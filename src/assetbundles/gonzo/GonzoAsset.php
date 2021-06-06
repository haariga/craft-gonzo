<?php


namespace martinherweg\craftgonzo\assetbundles\gonzo;


use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class GonzoAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@martinherweg/craftgonzo/web/assets/dist';
        $this->depends = [
            CpAsset::class,
        ];
        parent::init();
    }
}
