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
use haariga\craftgonzo\CraftGonzo;
use haariga\craftgonzo\helpers\ActiveComponent;
use haariga\craftgonzo\models\ComponentVariant;

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
    protected $allowAnonymous = ['index', 'render-template'];

    // Public Methods
    // =========================================================================

    /**
     * @param string $uri
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex(string $uri = '')
    {
        $oldMode = Craft::$app->view->getTemplateMode();
        Craft::$app->view->setTemplateMode(View::TEMPLATE_MODE_CP);

        $html = Craft::$app->view->renderTemplate('craft-gonzo/patternlib.twig', ['uri' => $uri]);
        Craft::$app->view->setTemplateMode($oldMode);
        Craft::$app->getView()->registerAssetBundle(GonzoAsset::class);

        return $html;
    }


    /**
     * @param string $slug
     *
     * @return string
     */
    public function actionRenderTemplate(string $slug)
    {
        $activeComponent = CraftGonzo::getInstance()->findActiveComponent->findActiveComponent($slug);
        $templatePath = $activeComponent['files']['twig'][0]['path'];
        $componentData = $activeComponent['config']->getVariants();
        $html = CraftGonzo::$plugin->renderComponent->renderTemplate($templatePath, $componentData);

        return $html;
    }
}
