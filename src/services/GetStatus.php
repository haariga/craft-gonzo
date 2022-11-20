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
use haariga\craftgonzo\exceptions\NoStatusFoundException;
use haariga\craftgonzo\models\ComponentStatus;
use haariga\craftgonzo\models\Settings;

/**
 * GetStatus Service
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
class GetStatus extends Component
{
    // Public Methods
    // =========================================================================

    public function getStatusByLabel(string $label): ComponentStatus | null
    {
        $statuses = collect(Settings::instance()->compStatus ?? []);
        return $statuses->filter(function ($status) use($label) {
            return $status->getLabel() == $label;
        })->first();
    }

    public function getStatusByKey(string $name): ComponentStatus | null
    {
        $statuses = collect(Settings::instance()->compStatus ?? []);
        return $statuses->filter(function ($status, $key) use($name) {
            return $key == $name;
        })->first();
    }

    public function getStatus(string $status): ComponentStatus
    {
        $status = $this->getStatusByKey($status) ?? $this->getStatusByLabel($status) ?? null;
        if (!$status) {
            throw new NoStatusFoundException('No Status with this Label or key found');
        }
        return $status;
    }
}
