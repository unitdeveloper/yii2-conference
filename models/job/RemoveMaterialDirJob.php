<?php

namespace app\models\job;


use app\models\Material;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class RemoveMaterialDirJob extends BaseObject implements JobInterface
{
    public $materials;

    public function execute($queue)
    {
        foreach ($this->materials as $material) {

            $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir;

            Material::removeDirectory($dir);
        }

        return true;
    }
}
