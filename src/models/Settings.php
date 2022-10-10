<?php

namespace haariga\craftgonzo\models;

use craft\base\Model;

class Settings extends Model
{
    public $compFolders = [];
    public $layoutFile = '/_layouts/patternlib.twig';
    public $comps = [];
    public $mqButtons = [];
    public $compStatus = [];
    public $pages = [];

    public function rules(): array
    {
        return [
            [['compFolders', 'comps',], 'required'],
        ];
    }
}
