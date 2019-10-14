<?php

    namespace martinherweg\craftgonzo\models;

use craft\base\Model;
    use craft\validators\ArrayValidator;

    class Settings extends Model
    {
        public $patternLibFolder = 'patternlib';
        public $optionsKey = 'opt';
        public $compFolders = [];
        public $subFolder = '';
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
            'fluid' => '100vw'
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

        public $pages = [
            'typography',
        ];

        public function init()
        {
            parent::init();
        }

        public function rules()
        {
            return [
                [['patternLibFolder', 'optionsKey'], 'string'],
                [
                    [
                        'compFolders',
                        'navigation',
                        'pages',
                        'mqButtons',
                        'compStatus'
                    ],
                    ArrayValidator::class
                ]
            ];
        }
    }
