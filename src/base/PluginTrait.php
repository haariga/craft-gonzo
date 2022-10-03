<?php

namespace haariga\craftgonzo\base;

use haariga\craftgonzo\assetbundles\gonzo\GonzoAsset;
use haariga\craftgonzo\CraftGonzo;
use haariga\craftgonzo\services\FindActiveComponent;
use haariga\craftgonzo\services\Gonzo;
use haariga\craftgonzo\services\RenderComponent;
use haariga\craftgonzo\services\TemplatesFolder;
use nystudio107\pluginvite\services\VitePluginService;

trait PluginTrait {
    public static CraftGonzo $plugin;

    private function _registerComponents(): void
    {
        $this->setComponents([
            'templatesFolder' => TemplatesFolder::class,
            'findActiveComponent' => FindActiveComponent::class,
            'renderComponent' => RenderComponent::class,
            'craftGonzo' => Gonzo::class,
            'vite' => [
                'class' => VitePluginService::class,
                'assetClass' => GonzoAsset::class,
                'useDevServer' => true,
                'devServerPublic' => 'http://localhost:3001',
                'serverPublic' => 'http://localhost:8000',
                'errorEntry' => '/src/js/app.ts',
                'devServerInternal' => 'http://localhost:3001',
                'checkDevServer' => true
            ],
        ]);
    }


    public function getVite(): VitePluginService
    {
        return $this->get('vite');
    }
}
