<?php
/**
 * Craft Gonzo plugin for Craft CMS 3.x
 *
 * Module Collection from your templates Folder
 *
 * @link      https://martinherweg.de
 * @copyright Copyright (c) 2021 Martin Herweg
 */

namespace haariga\craftgonzo\controllers;

use Craft;
use craft\web\Controller;
use craft\web\View;
use haariga\craftgonzo\assetbundles\gonzo\GonzoAsset;

/**
 * FrontEndRoutes Controller
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
 * @since     2.0.0-alpha.1
 */
class FrontEndRoutesController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/craft-gonzo/front-end-routes
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $oldMode = Craft::$app->view->getTemplateMode();
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);
        $html = Craft::$app->view->renderTemplate('craft-gonzo/patternlib.twig');
        Craft::$app->view->setTemplateMode($oldMode);
        Craft::$app->getView()->registerAssetBundle(GonzoAsset::class);

        return $html;
    }

    /**
     * Handle a request going to our plugin's actionDoSomething URL,
     * e.g.: actions/craft-gonzo/front-end-routes/do-something
     *
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the FrontEndRoutesController actionDoSomething() method';

        return $result;
    }
}
