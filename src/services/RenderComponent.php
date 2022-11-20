<?php

namespace haariga\craftgonzo\services;

use Craft;
use craft\base\Component;
use haariga\craftgonzo\CraftGonzo;
use haariga\craftgonzo\helpers\ActiveComponent;
use haariga\craftgonzo\models\ActiveComponentModel;
use haariga\craftgonzo\models\ComponentConfig;
use haariga\craftgonzo\models\ComponentVariant;

/**
 * RenderComponent Service
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Martin Herweg
 * @package   CraftGonzo
 * @since     2.0.0-alpha.1
 */
class RenderComponent extends Component
{
    /**
     * @param $templatePath
     * @param $variables
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \yii\base\Exception
     */
    public function renderTemplate($templatePath, $variables)
    {
        if (empty($variables)) {
            $variables = [new ComponentVariant()];
        }

        $layoutFile = CraftGonzo::$plugin->getSettings()->layoutFile;

        $layoutFile = Craft::$app->view->renderTemplate($layoutFile, [
            'templatePath' => $templatePath,
            'variables' => $variables->getData(),
        ]);

        return $layoutFile;
    }
}
