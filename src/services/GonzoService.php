<?php

    namespace martinherweg\craftgonzo\services;

    use craft\base\Component;
    use craft\elements\Asset;

    class GonzoService extends Component
    {
        public function getImage($id)
        {
            return Asset::findOne($id);
        }
    }
