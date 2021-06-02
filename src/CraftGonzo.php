<?php

    namespace martinherweg\craftgonzo;

    use Craft;
    use craft\base\Plugin;

    class CraftGonzo extends Plugin
    {
        public static $plugin;

        public function init()
        {
            parent::init();
            self::$plugin = $this;

            Craft::info(
                Craft::t(
                    'craft-gonzo',
                    '{name} plugin loaded',
                    ['name' => $this->name]
                ),
                __METHOD__
            );
        }
    }
