<?php
    /**
     * Craft Gonzo plugin for Craft CMS 3.x
     *
     * Module Collection from your templates Folder
     *
     * @link      https://martinherweg.de
     * @copyright Copyright (c) 2017 Martin Herweg
     */

    namespace martinherweg\craftgonzo\controllers;

    use craft\helpers\Template;
    use craft\helpers\UrlHelper;
    use craft\web\View;
    use martinherweg\craftgonzo\CraftGonzo;
    use martinherweg\craftgonzo\assetbundles\gonzo\GonzoAsset;
    use Craft;
    use craft\web\Controller;
    use Illuminate\Support\Collection;

    /**
     * Default Controller
     *
     * Generally speaking, controllers are the middlemen between the front end of
     * the CP/website and your plugin’s services. They contain action methods which
     * handle individual tasks.
     *
     * A common pattern used throughout Craft involves a controller action gathering
     * post data, saving it on a model, passing the model off to a service, and then
     * responding to the request appropriately depending on the service method’s response.
     *
     * Action methods begin with the prefix “action”, followed by a description of what
     * the method does (for example, actionSaveIngredient()).
     *
     * https://craftcms.com/docs/plugins/controllers
     *
     * @author    Martin Herweg
     * @package   CraftGonzo
     * @since     0.0.1
     */
    class DefaultController extends Controller
    {
        // Protected Properties
        // =========================================================================

        protected $templatesPath;
        protected $compFolders;
        protected $allowedExtensions;
        protected $optionsKey;
        /**
         * @var    bool|array Allows anonymous access to this controller's actions.
         *         The actions must be in 'kebab-case'
         * @access protected
         */
        protected $allowAnonymous = ['template-index', 'template-render', 'get-file-content', 'get-file-render'];

        // Public Methods
        // =========================================================================

        /**
         * Handle a request going to our plugin's index action URL,
         * e.g.: actions/craft-gonzo/default
         *
         * @return mixed
         */
        public function init()
        {
            $this->templatesPath = Craft::$app->view->getTemplatesPath();
            $this->compFolders = CraftGonzo::getInstance()->getSettings()->compFolders ? CraftGonzo::getInstance()->getSettings()->compFolders : [];
            $this->allowedExtensions = [
                'css',
                'scss',
                'js',
                'vue',
                'html'
            ];
            $this->optionsKey = CraftGonzo::getInstance()->getSettings()->optionsKey ? CraftGonzo::getInstance()->getSettings()->optionsKey : 'opt';
        }

        /**
         * Creates a tree-structured array of directories and files from a given root folder.
         *
         * Gleaned from: http://stackoverflow.com/questions/952263/deep-recursive-array-of-directory-structure-in-php
         *
         * @param string $dir
         * @param string $regex
         * @param boolean $ignoreEmpty Do not add empty directories to the tree
         * @return array
         */
        public function dirtree($dir, $regex = '', $ignoreEmpty = false, $depth = 0)
        {
            // https://stackoverflow.com/questions/18251505/file-structure-to-multidimensional-array
            $origin = new \IteratorIterator(new \DirectoryIterator($dir));
            $dirs = [];
            $config = null;

            foreach ($origin as $item) {
                if ($item->isDot()) {
                    continue;
                }

                $searchFolders = count($this->compFolders) ? in_array($item->getFilename(), $this->compFolders) : true;

                if ($item->isDir() && $searchFolders) {
                    $obj = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($item->getPathname(),
                        \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
                    $arr = [];
                    $test = $item->getFilename();
                    foreach ($obj as $info) {
                        $path = $info->isDir() ? [
                            $info->getFilename() => [
                                'name'   => $info->getFilename(),
                                'identifier' => $test . '.' . $info->getFilename(),
                                'config' => collect($this->getConfig($info->getRealPath()))
                                    ->filter(function ($value, $key) {
                                        return $value != null;
                                    })->toArray()
                            ]
                        ] : [$info->getFilename()];


                        for ($depth = $obj->getDepth() - 1; $depth >= 0; $depth--) {
                            $templates = [];
                            $assets = [];
                            $basename = pathinfo($info)['filename'];
                            $name = $info->getFilename();
                            $fullPath = $info->getRealPath();

                            $file = [
                                'name'         => $basename,
                                'extension'    => $info->getExtension(),
                                'filename'     => $name,
                                'fullPath'     => $fullPath,
                                'relativePath' => str_replace($this->templatesPath, '', $fullPath),
                            ];

                            switch ($info->getExtension()) {
                                case 'html':
                                case 'twig':
                                    $templates[] = $file;
                                    break;
                                case 'js':
                                case 'css':
                                case 'vue':
                                case 'scss':
                                    $assets[] = $file;
                                    break;
                            }
                            $path = [
                                $obj->getSubIterator($depth)->current()->getFilename() => [
                                    'templates' => $templates,
                                    'assets'    => $assets,
                                ]
                            ];
                        } // end of subfiles

                        $arr = array_merge_recursive($arr, $path);
                    }
                    $arr = collect($arr)
                        ->filter(function ($item) {
                            return (isset($item['config']) && count($item['config']));
                        })->filter(function ($item) {
                            return (isset($item['templates']) && count($item['templates']));
                        })->map(function ($item) {
                            if (isset($item['templates']) && isset($item['config'])) {
                                foreach ($item['templates'] as $template) {
                                    if (isset($item['config']['variants']) && is_array($item['config']['variants'])) {
                                        $html = Craft::$app->view->renderTemplate($template['relativePath'], [$this->optionsKey => reset($item['config']['variants'])]);
//                                        $item['name'] === 'richText' ? dd(trim(preg_replace('/\s\s+/', '', $html))) : '';
                                    } else {
                                        $html = 'no options available';
                                    }

                                    $item['templateRender'][] = [
                                        'extension' => $item['config']['title'] ?? '',
                                        'code' => !empty(trim($html)) ? trim($html) : 'no template code available',
                                    ];
                                }
                            }
                            return $item;
                        });
                    $dirs[$item->getFilename()]['children'] = $arr->sortBy(function ($item, $key) {
                        return $item['name'];
                    })->values()->all();
                }
            }

            $collection = new Collection($dirs);
            $collection = $collection->filter(function ($item) {
                return count($item['children']);
            })->sortBy(function ($item, $key) {
                return $key;
            });

            return $collection->map(function ($item, $key) {
                return [
                    'name'     => $key,
                    'children' => $item['children']
                ];
            })->values()->all();
        }

        public function array_merge_recursive_distinct(array &$array1, array &$array2)
        {
            $merged = $array1;
            foreach ($array2 as $key => &$value) {
                if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                    $merged[$key] = $this->array_merge_recursive_distinct($merged[$key], $value);
                } else {
                    $merged[$key] = $value;
                }
            }
            return $merged;
        }

        public function getConfig(string $path)
        {
            $options = new Collection();
            $mergedOptions = collect();
            $configFiles = glob($path . '/*config*');
            foreach ($configFiles as $config) {
                if (pathinfo($config, PATHINFO_EXTENSION) === 'json') {
                    $json = file_get_contents($config);
                    $jsonVariables = json_decode($json, true);
                    $jsonVariables = collect($jsonVariables);
                    $options = $options->merge($jsonVariables);
                }
                if (pathinfo($config, PATHINFO_EXTENSION) === 'php') {
                    $opt = include $config;
                    if (isset($opt)) {
                        $collectedOptions = collect($opt);
                        $array1 = $options->toArray();
                        $array2 = $collectedOptions->toArray();
                        $mergedOptions = $this->array_merge_recursive_distinct($array1, $array2);
                        $mergedOptions = collect($mergedOptions);
                    }
                }
            }

            return $mergedOptions->isNotEmpty() ? $mergedOptions->toArray() : $options->toArray();
        }

        public function actionTemplateIndex()
        {
            $treeView = $this->dirtree($this->templatesPath, '', true);
            $variables['templates'] = $treeView;
            $oldMode = Craft::$app->view->getTemplateMode();
            Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
            $variables['pluginSettings'] = CraftGonzo::getInstance()->getSettings();
            $variables['patternlibBaseUrl'] = UrlHelper::siteUrl();
            $html = Craft::$app->view->renderTemplate('craft-gonzo/patternlib.twig', $variables);
            Craft::$app->view->setTemplateMode($oldMode);
            Craft::$app->getView()->registerAssetBundle(GonzoAsset::class);
            return $html;
        }


        /**
         * Render given Module in patternlibRenderer Template
         * @param array $variables
         * @return \yii\web\Response
         */
        public function actionTemplateRender(string $component, string $variant)
        {

            if (!$component) {
                return 'Kein Template gefunden.';
            } elseif (!$variant) {
                return 'Keine Variante gefunden.';
            }

            $variables = [];
            $pathinfo = pathinfo($component);
            $modulePath = $this->templatesPath . '/' . $pathinfo['dirname'];
            $config = $this->getConfig($modulePath);
            $variantQueryString = $variant;
            $variables['component'] = $component;
            $variables['templateOptions'] = $config['variants'][$variantQueryString] ?? '';

            if (!$variables['templateOptions']) {
                return 'Keine Config gefunden';
            }

            return $this->renderTemplate('patternlib/index', $variables);
        }

        public function actionGetFileContent(string $file)
        {

            $extension = pathinfo($file, PATHINFO_EXTENSION);

            if (!in_array($extension, $this->allowedExtensions)) {
                return null;
            }

            Craft::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
            $modulePath = $this->templatesPath . '/' . $file;
            $fileContents = file_get_contents($modulePath);
            return $fileContents;
        }

        public function actionGetFileRender()
        {
            $this->requirePostRequest();

            $data = Craft::$app->getRequest()->post();

            $options = json_decode($data['meta'], true);

            $html = $this->renderTemplate($data['file'], ['opt' => $options]);

            return $html;
        }
    }
