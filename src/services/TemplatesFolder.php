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
    private $pathsToSearch = ['Embeds' => '_embeds', 'Atoms' => '_atoms'];

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

    public function readTemplatesFolder()
    {
        $paths = $this->buildComponentTree(true);

        return $paths;
    }

    public function getComponents()
    {
        $tree = $this->buildComponentTree();
        $tree = $this->removeEmptyValues($tree);
        return $tree;
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

            if (in_array($filename, array_values($this->pathsToSearch))) {
                return true;
            }

            return false;
        });

        $iterator = new RecursiveIteratorIterator($filtered, RecursiveIteratorIterator::SELF_FIRST);

        $tree = [];

        foreach ($iterator as $fileinfo) {
            $comps = collect($this->pathsToSearch);
            $name = $comps->search($fileinfo->getFilename());
            $sub_path_name = $iterator->getSubPathName();
            $parts = explode(DIRECTORY_SEPARATOR, $sub_path_name);
            array_pop($parts);

            $parrentAttr = &$tree;

            foreach ($parts as $part) {
                $parrentAttr = &$parrentAttr[$part];
            }

            if ($fileinfo->isDir()) {
                $parrentAttr[$name]['config'] = [
                    'title' => $name,
                ];
                $parrentAttr[$name]['children'] = $this->buildFileTreeV2($fileinfo->getPathname());
            }
        }
        unset($parrentAttr);

        return $tree;
    }

    private function buildFileTreeV2(string $dir)
    {

        $_dir = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);

        $tree = [];

        foreach ($_dir as $item) {
            $name = basename($item->getPathname());
            $attr = &$tree;
            if ($item->isDir()) {
                $attr[$name] = [];
                if (!empty(glob($item->getPathname().'/Gonzo*.php'))) {
                    $attr[$name]['files'][] = $item->getFilename();
                } else {
                    $attr[$name]['children'] = $this->buildFileTreeV2($item->getPathname());
                }
            }
        }

        $tree = $this->removeEmptyValues($tree);

        unset($attr);

        return $tree;
    }


    private function buildFileTree($dir, $full = false)
    {
        $_dir = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($_dir, RecursiveIteratorIterator::SELF_FIRST, RecursiveIteratorIterator::CATCH_GET_CHILD);

        $tree = [];
        $level = 0;

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
                if ($iterator->callGetChildren()->isDir()) {
                    $parrentAttr[$name]['children'] = $this->buildFileTree($fileinfo->getPathname(), $full);
                }
            } else {
                if (!$full) {
                    // TODO: Optimize Condition to only add comps added in the comps array
                    if (!empty(glob($fileinfo->getPathInfo()->getPathname().'/Gonzo*.php'))) {
                        if (mb_strpos($name, 'Config')) {
                            $comps = collect(CraftGonzo::$plugin->getSettings()->comps);
                            $class = $comps->first(function($value, $key) use ($name) {
                                $basename = basename($name, '.php');
                                return $key === $basename;
                            });
                            if ($class) {
                                $class->setPath($_dir->getPathname().DIRECTORY_SEPARATOR);
                                $class->setTemplatePath($_dir->getSubPathname().DIRECTORY_SEPARATOR);
                                $parrentAttr['configs'][] = $class;
                                $parrentAttr['config']['title'] = basename($fileinfo->getPathinfo()->getPathname().DIRECTORY_SEPARATOR);
                            }
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
