<?php

    namespace martinherweg\craft3gonzo\models;

    use craft\base\Model;

    class Settings extends Model
    {
        public $searchFolders = [];

        public function rules()
        {
            return [['searchFolders']];
        }
    }
