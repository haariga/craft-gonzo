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
use haariga\craftgonzo\exceptions\NewSearchStringException;
use haariga\craftgonzo\helpers\ActiveComponent;
use haariga\craftgonzo\models\ComponentConfig;

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
    protected array|int|bool $allowAnonymous = ['index', 'render-template', 'get-file-content', 'get-template-render', 'search-for-component'];

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
        $templatePath = $activeComponent['files']['twig']['path'];
        $componentData = $activeComponent['config']->getVariants();
        $html = CraftGonzo::$plugin->renderComponent->renderTemplate($templatePath, $componentData);

        return $html;
    }

    public function actionGetTemplateRender()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();
        $slug = $request->getBodyParam('slug');
        $activeComponent = CraftGonzo::getInstance()->findActiveComponent->findActiveComponent($slug);
        $templatePath = $activeComponent['files']['twig']['path'];
        $componentData = $activeComponent['config']->getVariants();
        $html = Craft::$app->view->renderTemplate($templatePath, $componentData[0]->getData());

        return $html;
    }


    public function actionGetFileContent()
    {
        $this->requirePostRequest();

        $request = Craft::$app->getRequest();

        $code = CraftGonzo::getInstance()->filePreview->getFileContent($request->getBodyParam('filePath'));

        return $code;
    }

    public function actionSearchForComponent()
    {
        $this->requirePostRequest();

        $request = Craft::$app->getRequest();
        $searchString = $request->getBodyParam('searchString');

        if (!$searchString) {
            return $this->asJson([
                'searchValue' => $searchString,
                'results' => [],
                'errors' => new NewSearchStringException(204, 'No Search String provided'),
            ]);
        }

        $tree = CraftGonzo::getInstance()->templatesFolder->getComponentsArray();
        $collectedTree = collect($tree);

        $filteredTree = $collectedTree->filter(function($item) use ($searchString) {
            $title = $item['config']->getTitle();
            $pattern = "/$searchString/i";
            return preg_match($pattern, $title);
        });

        return $this->asJson([
            'searchValue' => $searchString,
            'results' => $filteredTree->values()->all(),
        ]);
    }
}
