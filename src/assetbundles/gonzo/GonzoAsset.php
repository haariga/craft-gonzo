<?php

    namespace martinherweg\craftgonzo\assetbundles\gonzo;

    use Craft;
    use craft\web\AssetBundle;
    use craft\web\assets\cp;

    class GonzoAsset extends AssetBundle
    {
        public function init()
        {
            $this->sourcePath = '@martinherweg/craftgonzo/assetbundles/gonzo/dist';

            $this->js = ['js/CraftGonzo.js'];
            $this->css = ['css/CraftGonzo.css'];

            parent::init();
        }
    }
