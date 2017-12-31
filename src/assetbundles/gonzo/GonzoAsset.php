<?php

    namespace martinherweg\craft3gonzo\assetbundles\gonzo;

    use Craft;
    use craft\web\AssetBundle;
    use craft\web\assets\cp;

    class GonzoAsset extends AssetBundle
    {
        public function init()
        {
            $this->sourcePath = '@martinherweg/craft3gonzo/assetbundles/gonzo/dist';

            $this->js = ['js/Craft3Gonzo.js'];

            parent::init();
        }
    }
