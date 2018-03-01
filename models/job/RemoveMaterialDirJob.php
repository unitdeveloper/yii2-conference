<?php

namespace app\models\job;


use app\models\Material;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class RemoveMaterialDirJob extends BaseObject implements JobInterface
{
    public $materials;

    /**
     * Deleting work directory materials
     * @param \yii\queue\Queue $queue
     * @return bool
     */
    public function execute($queue)
    {
        foreach ($this->materials as $material) {

            if ($material->dir) {

                $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir;

                if (file_exists($dir)) {
                    Material::removeDirectory($dir);
                }
            }
        }

        return true;
    }
}
