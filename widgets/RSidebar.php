<?php
namespace app\widgets;

use app\models\Archive;
use yii\base\Widget;
use yii\helpers\Html;

class RSidebar extends Widget
{
//    public $message;

    public function init()
    {
        parent::init();
//        if ($this->message === null) {
//            $this->message = 'Hello World';
//        }
    }

    public function run()
    {
        $archive = Archive::find()->orderBy('id DESC')->one();

        return $this->renderFile(\Yii::getAlias('@app').'/views/site/rightSidebar.php', [
            'archive' => $archive
        ]);
    }
}
