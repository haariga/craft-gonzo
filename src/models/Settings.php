<?php

    namespace martinherweg\craft3gonzo\models;

use craft\base\Model;
    use craft\validators\ArrayValidator;

    class Settings extends Model
    {
        public $patternLibFolder = 'patternlib';
        public $compFolders = [];
        public $navigation = [
            0 => [
                'name' => 'home',
                'link' => 'patternlib/'
            ],
            1 => [
                'name' => 'typo',
                'link' => 'patternlib/typo/',
            ],
        ];

        public $mqButtons = [
            'min' => '320px',
            'xs' => '400px',
            's' => '600px',
            'm' => '800px',
            'l' => '1000px',
            'max' => '1440px',
            'fluid' => '100%'
        ];

        public $compStatus = [
            0 => [
                'name' => 'prototype',
                'color' => 'lightblue',
            ],
            1 => [
                'name' => 'wip',
                'color' => 'orange',
            ],
            2 => [
                'name' => 'done',
                'color' => '#bada88',
            ],
            3 => [
                'name' => 'discarded',
                'color' => 'red',
            ],
        ];

        public function init()
        {
            parent::init();
        }

        public function rules()
        {
            return [
                ['patternLibFolder', 'string'],
                [
                    [
                        'compFolders',
                        'navigation',
                        'mqButtons',
                        'compStatus'
                    ],
                    ArrayValidator::class
                ]
            ];
        }
    }
