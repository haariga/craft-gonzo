<?php
    /**
     * Craft Gonzo plugin for Craft CMS 3.x
     *
     * Module Collection from your templates Folder
     *
     * @link      https://martinherweg.de
     * @copyright Copyright (c) 2017 Martin Herweg
     */

    namespace martinherweg\craftgonzo;

    use Craft;
    use craft\base\Plugin;
    use craft\services\Plugins;
    use craft\events\PluginEvent;
    use craft\web\UrlManager;
    use craft\events\RegisterUrlRulesEvent;
    use martinherweg\craftgonzo\controllers\DefaultController;
    use yii\base\Event;

    /**
     * Craft plugins are very much like little applications in and of themselves. We’ve made
     * it as simple as we can, but the training wheels are off. A little prior knowledge is
     * going to be required to write a plugin.
     *
     * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
     * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
     *
     * https://craftcms.com/docs/plugins/introduction
     *
     * @author    Martin Herweg
     * @package   CraftGonzo
     * @since     0.0.1
     *
     */
    class CraftGonzo extends Plugin
    {
        // Static Properties
        // =========================================================================

        /**
         * Static property that is an instance of this plugin class so that it can be accessed via
         * CraftGonzo::$plugin
         *
         * @var CraftGonzo
         */
        public static $plugin;

        // Public Methods
        // =========================================================================

        /**
         * Set our $plugin static property to this class so that it can be accessed via
         * CraftGonzo::$plugin
         *
         * Called after the plugin class is instantiated; do any one-time initialization
         * here such as hooks and events.
         *
         * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
         * you do not need to load it in your init() method.
         *
         */

        public $controllerMap = [
            'template-index'  => DefaultController::class,
            'template-render' => DefaultController::class,
            'get-file-content' => DefaultController::class,
    ];

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Register our site routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['patternlib'] = 'craft-gonzo/default/template-index';
                $event->rules['patternlib/getfilecontent/<file:\S+>'] = 'craft-gonzo/default/get-file-content';
                $event->rules['patternlib/getfilerender'] = 'craft-gonzo/default/get-file-render';
                $event->rules['patternlib/<component:\S+>'] = 'craft-gonzo/default/template-render';
            }
        );

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

        /**
         * Logging in Craft involves using one of the following methods:
         *
         * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
         * Craft::info(): record a message that conveys some useful information.
         * Craft::warning(): record a warning message that indicates something unexpected has happened.
         * Craft::error(): record a fatal error that should be investigated as soon as possible.
         *
         * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
         *
         * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
         * the category to the method (prefixed with the fully qualified class name) where the constant appears.
         *
         * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
         * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
         *
         * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
         */
        Craft::info(
            Craft::t(
                'craft-gonzo',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================
        protected function createSettingsModel()
        {
            return new models\Settings();
        }

}
