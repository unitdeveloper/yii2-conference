<?php
namespace app\widgets;

use app\models\Archive;
use yii\base\Widget;
use yii\helpers\Html;

class RSidebar extends Widget
{
    public function init()
    {
        parent::init();
    }

    /**
     * Generating html for right sidebar
     * @return string
     */
    public function run()
    {
        $archive = Archive::find()->orderBy('id DESC')->one();

        return $this->renderFile(\Yii::getAlias('@app').'/views/site/rightSidebar.php', [
            'archive' => $archive
        ]);
    }
}
