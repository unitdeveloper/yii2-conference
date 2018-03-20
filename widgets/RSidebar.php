<?php
namespace app\widgets;

use app\models\Archive;
use app\models\Material;
use yii\base\Widget;

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
        $archive = Archive::find()->orderBy('id DESC')->active()->limit(2)->all();

        $tags = Material::getRandomTags();

        return $this->renderFile(\Yii::getAlias('@app').'/views/widgets/rightSidebar.php', [
            'archive' => $archive,
            'tags' => $tags,
        ]);
    }
}
