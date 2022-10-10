<?php


namespace haariga\craftgonzo\assetbundles\gonzo;


use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class GonzoAsset extends AssetBundle
{
    public function init(): void
    {
        $this->sourcePath = '@haariga/craftgonzo/web/assets/dist';
        $this->depends = [
            CpAsset::class,
        ];
        parent::init();
    }
}
