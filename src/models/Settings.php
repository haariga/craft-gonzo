<?php

namespace haariga\craftgonzo\models;

use craft\base\Model;

class Settings extends Model
{
    public $compFolders = [];
    public $comps = [];
    public $mqButtons = [];
    public $compStatus = [];
    public $pages = [];

    public function rules()
    {
        return [
            [['compFolders'], 'required'],
        ];
    }
}
