<?php
/**
 * Craft Gonzo plugin for Craft CMS 3.x
 *
 * Module Collection from your templates Folder
 *
 * @link      https://martinherweg.de
 * @copyright Copyright (c) 2022 Martin Herweg
 */

namespace haariga\craftgonzo\services;

use Craft;
use craft\base\Component;
use FilesystemIterator;
use haariga\craftgonzo\CraftGonzo;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use function Composer\Autoload\includeFile;

/**
 * TemplatesFolder Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Martin Herweg
 * @package   CraftGonzo
 * @since     2.0.0-alpha.1
 */
class TemplatesFolder extends Component
{
    private $templateDir = '';
    private $pathsToSearch = ['_embeds', '_atoms'];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $oldTemplateMode = Craft::$app->view->getTemplateMode();
        Craft::$app->view->setTemplateMode('site');
        $this->templateDir = Craft::$app->view->getTemplatesPath();
        Craft::$app->view->setTemplateMode($oldTemplateMode);
        $this->pathsToSearch = CraftGonzo::$plugin->getSettings()->compFolders;
    }
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     CraftGonzo::$plugin->templatesFolder->exampleService()
     *
     * @return mixed
     */
    public function readTemplatesFolder()
    {

        $paths = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->templateDir));
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                continue;
            }
            $paths[dirname($file->getPathname())][] = $file->getPathname();
        }
        $collection = collect($paths);
        $components = $collection->filter(function($comp) {
            return collect($comp)->contains(function($value) {
                return str_contains($value, 'config');
            });
        })->mapToGroups(function($item) {
            return [pathinfo($item[0])['dirname'] => $item];
        });

        return $components;
    }

    public function readTemplatesFolderV2()
    {
        $paths = $this->buildComponentTree(true);

        return $paths;
    }

    public function getComponents()
    {
        $tree = $this->buildComponentTree();
        return $this->removeEmptyValues($tree);
    }

    /**
     * Remove any elements where the value is empty
     *
     * @param array $array the array to walk
     *
     * @return array
     */
    private function removeEmptyValues(array &$array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = $this->removeEmptyValues($value);
            }
            if (empty($value)) {
                unset($array[$key]);
            }
        }
        return $array;
    }

    private function buildComponentTree($full = false)
    {
        $dir = new RecursiveDirectoryIterator($this->templateDir, FilesystemIterator::SKIP_DOTS);
        $filtered = new RecursiveCallbackFilterIterator($dir, function($current, $key, $iterator) {
            $filename = $current->getFilename();

            if (in_array($filename, $this->pathsToSearch)) {
                return true;
            }

            return false;
        });

        $iterator = new RecursiveIteratorIterator($filtered, RecursiveIteratorIterator::SELF_FIRST);

        $tree = [];

        foreach ($iterator as $fileinfo) {
            $name = $fileinfo->getFilename();
            $sub_path_name = $iterator->getSubPathName();
            $parts = explode(DIRECTORY_SEPARATOR, $sub_path_name);
            array_pop($parts);

            $parrentAttr = &$tree;

            foreach ($parts as $part) {
                $parrentAttr = &$parrentAttr[$part];
            }

            if ($fileinfo->isDir()) {
                $parrentAttr[$name] = $this->buildFileTree($fileinfo->getPathname(), $full);
            }
        }
        unset($parrentAttr);

        return $tree;
    }


    private function buildFileTree($dir, $full = false)
    {
        $_dir = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($_dir, RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);

        $tree = [];

        foreach ($iterator as $fileinfo) {
            $name = $fileinfo->getFilename();
            $path = $fileinfo->getPathname();
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $sub_path_name = $iterator->getSubPathName();
            $parts = explode(DIRECTORY_SEPARATOR, $sub_path_name);
            array_pop($parts);

            $parrentAttr = &$tree;

            foreach ($parts as $part) {
                $parrentAttr = &$parrentAttr[$part];
            }

            if ($fileinfo->isDir()) {
                $parrentAttr[$name] = [];
            } else {
                if (!$full) {
                    if (!empty(glob($_dir->getPathname() . '/Gonzo*.php'))) {
                        if (str_contains($name, 'Config')) {
                            // alternatively use plugin settings to reference config instances
                            // init the class instance in the config and use key value pairs to compare here
                            // and use the class instance in the config
                            require_once $path;
                            $class = basename($path, '.php');
                            $instance =new $class();
                            $instance->setPath($_dir->getPathname() . DIRECTORY_SEPARATOR);
                            $parrentAttr['config'] = $instance;
                        } else {
                            $parrentAttr['files'][] = [
                                'filename' => $name,
                                'filepath' => $path,
                                'filetype' => $type,
                            ];
                        }
                    }
                } else {
                    $parrentAttr['files'][] = [
                        'filename' => $name,
                        'filepath' => $path,
                        'filetype' => $type,
                    ];
                }
            }
        }

        unset($parrentAttr);

        return $tree;
    }
}
