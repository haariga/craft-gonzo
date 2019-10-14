<?php

    namespace martinherweg\craftgonzo\services;

    use craft\base\Component;
    use craft\elements\Asset;
    use Faker\Factory;
    use Faker\Generator;

    class GonzoService extends Component
    {
        public function getImage($id)
        {
            return Asset::findOne($id);
        }


        /**
         * @return Generator
         */
        public function faker()
        {
            $faker = Factory::create('de_de');

            return $faker;
        }
    }
