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

use haariga\craftgonzo\CraftGonzo;

use Craft;
use craft\base\Component;

/**
 * FilePreview Service
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
class FilePreview extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     CraftGonzo::$plugin->filePreview->exampleService()
     *
     * @return mixed
     */
    public function getFileContent(string $filepath): string
    {
        $templatesFolder = Craft::$app->view->getTemplatesPath();
        $result = file_get_contents($templatesFolder . $filepath);

        return $result;
    }
}
