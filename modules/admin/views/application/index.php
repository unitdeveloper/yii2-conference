<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Applications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                //            ['class' => 'yii\grid\SerialColumn'],

                //            'id',
                [
                    'attribute' => 'participant_id',
                    'value' => function ($data) {
                        $participant = $data->participant;
                        $html = Html::a(Html::encode($participant->email), \yii\helpers\Url::to(['/admin/participant/view', 'id' => $participant->id])) . '<br>';
                        return $html;
                    },
                    'format' => 'raw',
                    'label' => 'Participant email'
                ],
                [
                    'attribute' => 'conference_id',
                    'filter' => \app\models\Conference::find()->select(['name', 'id'])->indexBy('id')->column(),
                    'value' => 'conference.name'
                ],
                [
                    'attribute' => 'category_id',
                    'filter' => \app\models\Category::find()->select(['name', 'id'])->indexBy('id')->column(),
                    'value' => 'category.name'
                ],
                [
                    'attribute' => 'username',
                    'value' => function ($data) {
                        $user = $data->user;
                        if ($user)
                            return $user->username;
                        return null;
                    },
                    'format' => 'raw',
                    'label' => 'User name'
                ],
                [
                    'attribute' => 'material_id',
                    'filter' => false,
                    'value' => function ($data) {
                        /** @var \app\models\Material $material */
                        $material = $data->material;
                        if (!$material)
                            return Html::tag('span', 'Матеріали відсутні');

                        $html = '';
                        if ($material->material_name)
                            $html .= Html::a(Html::encode($material->material_name), \yii\helpers\Url::to(['/admin/material/view', 'id' => $material->id])) . '<br>';
                        else
                            $html .= Html::a(Html::encode($material->id), \yii\helpers\Url::to(['/admin/material/view', 'id' => $material->id])) . '<br>';

                        return $html;
                    },
                    'format' => 'raw',
                ],
                //            'material_id',
                [
                    'attribute' => 'created_at',
                    'value' => 'created_at',
                    'filter' => \dosamigos\datepicker\DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'template' => '{addon}{input}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-d',
                        ]
                    ]),
                    'format' => 'date',
                    'label' => 'Created at',
                ],
                [
                    'attribute' => 'status',
                    'filter' => \app\models\Application::getStatusesModeration(),
                    //                    'format' => 'boolean',
                    'value' => function ($data) {
                        return $data->statusesModeration[$data->status];
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]);
    } catch (Exception $e) {} ?>
</div>
