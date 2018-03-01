<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

class ConfigFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Config';
    public $dataFile = '@app/fixtures/data/config.php';
}