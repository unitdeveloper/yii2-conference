<?php

namespace app\controllers;


use app\models\Material;
use app\models\search\MaterialSearch;
use yii\data\ActiveDataProvider;

class ParticipantsController extends SiteController
{
    /**
     * Lists all Participants conference.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Material::find()->active()->joinWith(['category']),
            'sort' => [
                'defaultOrder' => ['author' => SORT_ASC],
                'attributes' => [
                    'material_name',
                    'author',
                    'category_id' => [
                        'asc' => ['{{%category}}.name' => SORT_ASC],
                        'desc' => ['{{%category}}.name' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
