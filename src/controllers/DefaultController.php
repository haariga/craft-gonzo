<?php
/**
 * Craft 3 Gonzo plugin for Craft CMS 3.x
 *
 * Module Collection from your templates Folder
 *
 * @link      https://martinherweg.de
 * @copyright Copyright (c) 2017 Martin Herweg
 */

namespace martinherweg\craft3gonzo\controllers;

use craft\web\View;
use martinherweg\craft3gonzo\Craft3Gonzo;
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
 * @package   Craft3Gonzo
 * @since     0.0.1
 */
class DefaultController extends Controller
{
    // Protected Properties
    // =========================================================================

    protected $templatesPath;
    protected $searchFolders;
    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['template-index', 'template-render'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/craft-3-gonzo/default
     *
     * @return mixed
     */
    public function init()
    {
        $this->templatesPath = \Craft::$app->view->getTemplatesPath();
        $this->searchFolders = Craft3Gonzo::$plugin->getSettings('searchFolders') ? Craft3Gonzo::$plugin->getSettings('searchFolders') : [];
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

            $searchFolders = count($this->searchFolders) ? in_array($item->getFilename(), $this->searchFolders) : true;

            if ($item->isDir() && $searchFolders) {
                $obj = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($item->getPathname(), \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
                $arr = [];
                foreach ($obj as $info) {
                    $path = $info->isDir() ? [$info->getFilename() => [
                        'config' => collect($this->getConfig($info->getRealPath()))
                            ->filter(function ($value, $key) {
                                return $value != null;
                            })->toArray()
                    ]] : [$info->getFilename()];

                    for ($depth = $obj->getDepth() - 1; $depth >= 0; $depth--) {
                        $templates = [];
                        $assets = [];
                        $basename = pathinfo($info)['filename'];
                        $name = $info->getFilename();
                        $fullPath = $info->getRealPath();

                        $file = [
                            'name' => $basename,
                            'extension' => $info->getExtension(),
                            'filename' => $name,
                            'fullPath' => $fullPath,
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
                        $path = [$obj->getSubIterator($depth)->current()->getFilename() => [
                            'templates' => $templates,
                            'assets' => $assets,
                        ]];
                    }
                    $arr = array_merge_recursive($arr, $path);
                }
                $dirs[$item->getFilename()]['children'] = $arr;
            }
        }

        $collection = new Collection($dirs);
        return $collection;
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
                include_once $config;
                if (isset($opt)) {
                    $mergedOptions = $options->merge($opt);
                }
            }
        }

        return $mergedOptions->isNotEmpty() ? $mergedOptions->toArray() : $options->toArray();
    }

    public function actionTemplateIndex()
    {
        $treeView = $this->dirtree($this->templatesPath, '', true);
        $variables['templates'] = $treeView->toArray();
        $oldMode = \Craft::$app->view->getTemplateMode();
        \Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        $html = \Craft::$app->view->renderTemplate('craft-3-gonzo/styleguide.twig', $variables);
        \Craft::$app->view->setTemplateMode($oldMode);
        return $html;
    }


    /**
     * Render given Module in StyleguideRenderer Template
     * @param array $variables
     * @return \yii\web\Response
     */
    public function actionTemplateRender(array $variables)
    {
        $pathinfo = pathinfo($variables['myVariable']);
        $modulePath = $this->templatesPath . $pathinfo['dirname'];
        $variables['component'] = $variables['myVariable'];
        $variables['templateOptions'] = $this->getConfig($modulePath);

        return $this->renderTemplate('styleguideRenderer', $variables);
    }
}
