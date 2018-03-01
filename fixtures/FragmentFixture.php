<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

class FragmentFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Fragment';
    public $dataFile = '@app/fixtures/data/fragment.php';
} 