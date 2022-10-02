<?php
/**
 * Craft Gonzo plugin for Craft CMS 3.x
 *
 * Module Collection from your templates Folder
 *
 * @link      https://martinherweg.de
 * @copyright Copyright (c) 2021 Martin Herweg
 */

namespace haariga\craftgonzo\variables;

use haariga\craftgonzo\CraftGonzo;
use haariga\craftgonzo\helpers\ActiveComponent;
use haariga\craftgonzo\models\ActiveComponentModel;
use nystudio107\pluginvite\variables\ViteVariableInterface;
use nystudio107\pluginvite\variables\ViteVariableTrait;

use Craft;

/**
 * Craft Gonzo Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.craftGonzo }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Martin Herweg
 * @package   CraftGonzo
 * @since     2.0.0-alpha.1
 */
class CraftGonzoVariable implements ViteVariableInterface
{
    use ViteVariableTrait;
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.craftGonzo.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.craftGonzo.exampleVariable(twigValue) }}
     *
     */

    /**
     * @return array|mixed
     */
    public function getTemplates()
    {
        $templates = CraftGonzo::$plugin->templatesFolder->readTemplatesFolder();

        return $templates;
    }

    /**
     * @return array
     */
    public function getComponents()
    {
        return CraftGonzo::$plugin->templatesFolder->getComponents();
    }

    /**
     * @param string $uri
     *
     * @return mixed|null
     */
    public function getActiveComponent(string $uri)
    {
        $activeComponent = CraftGonzo::$plugin->findActiveComponent->findActiveComponent($uri);

        return $activeComponent;
    }
}
