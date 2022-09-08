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
use craft\helpers\StringHelper;
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
        $paths = $this->buildComponentTree();

        return $paths;
    }

    private function cleanUp($tree)
    {
        $tree = $this->removeEmptyValues($tree);
        $tree = $this->removeNonSuitableFolders($tree);

        return $tree;
    }

    public function getComponents()
    {
        $tree = $this->buildComponentTree();
        $tree = $this->cleanUp($tree);
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

    private function array_flatten_with_keys($a, &$collection = [])
    {
        if (is_array($a)) {
            foreach ($a as $key => $item) {
                array_push($collection, $key);
                $this->array_flatten_with_keys($item, $collection);
            }
        }

        return $collection;
    }

    private function searchForFiles(array &$children): array
    {
        foreach ($children as $key => $child) {
            $flattened = collect($this->array_flatten_with_keys($child));
            if ((is_array($child) && array_key_exists('files', $child)) || $flattened->contains('files')) {
                $children[$key] = $child;
            } else {
                unset($children[$key]);
            }
        }

        return $children;
    }

    private function removeNonSuitableFolders(array &$tree): array
    {
        foreach ($tree as $key => $item) {
            if (array_key_exists('children', $item)) {
                $tree[$key]['children'] = $this->searchForFiles($item['children']);
            }
        }

        return $tree;
    }

    private function buildComponentTree()
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
                $subtree = [];
                $parrentAttr[$name]['children'] = $this->buildFileTree($fileinfo, $subtree);
            }
        }
        unset($parrentAttr);

        return $tree;
    }

    private function buildFileTree(\SplFileInfo $dir, array $tree, bool $config = false): array
    {
        $_dir = new \RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);

        foreach ($_dir as $item) {
            $name = $item->getBasename();
            if ($item->isDir()) {
                if (!empty(glob($item->getPathname().'/Gonzo*.php'))) {
                    $tree[$name] = [];
                    $tree[$name]['files'] = $this->buildFileTree($item, []);
                    $tree[$name]['config'] = collect($this->buildFileTree($item, [], true))->all();
                } else {
                    $tree[$name]['title'] = $name;
                    $tree[$name]['children'] = $this->buildFileTree($item, []);
                }
            } else {
                if ($config) {
                    if (mb_strpos($item->getBasename(), 'Config')) {
                        $comps = collect(CraftGonzo::$plugin->getSettings()->comps);
                        $class = $comps->first(function($value, $key) use ($name) {
                            $basename = basename($name, '.php');
                            return $key === $basename;
                        });
                        if ($class) {
                            $class->setPath($_dir->getPathname().DIRECTORY_SEPARATOR);
                            $class->setTemplatePath($_dir->getSubPathname().DIRECTORY_SEPARATOR);
                            $slug = dirname(str_replace($this->templateDir, '', $item->getPathname()));
                            $class->setSlug($slug . '/' . StringHelper::slugify($class->getTitle() ?? $item->getBasename('.' . $item->getExtension())));
                            $fileIdentfier = $class->getFileIdentifier() !== '' ? $class->getFileIdentifier() : ($class->getTitle() ?? 'no-identfier');
                            $tree['configs'][StringHelper::camelCase($fileIdentfier)] = $class;
                            $tree['slug'] = $slug . '/';
                            $tree['title'] = basename($item->getPathinfo()->getPathname().DIRECTORY_SEPARATOR);
                        }
                    }
                } else {
                    if ($item->getExtension() !== 'php') {
                        $basename = $item->getBasename('.' . $item->getExtension());
                        $tree[$basename][$item->getExtension()] = collect($tree[$basename][$item->getExtension()] ?? []);
                        $file = [
                            'filename' => $item->getFilename(),
                            'extension' => $item->getExtension(),
                            'size' => $item->getSize(),
                        ];
                        $tree[$basename][$item->getExtension()]->push($file);
                    }
                }
            }
        }

        return $tree;
    }
}
