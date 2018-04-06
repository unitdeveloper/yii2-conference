<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\LetterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Letters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letter-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('Create Letter', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'participant_id',
                    'value' => function ($data) {
                        $participant = $data->participant;
                        $html = Html::a(Html::encode($participant->email), \yii\helpers\Url::to(['/admin/participant/view', 'id' => $participant->id])).'<br>';
                        return $html;
                    },
                    'format' => 'raw',
                    'label' => 'Participant email'
                ],
                [
                    'attribute' => 'user_id',
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
                    'attribute' => 'conference_id',
                    'filter' => \app\models\Conference::find()->select(['name', 'id'])->indexBy('id')->column(),
                    'value' => 'conference.name'
                ],
//                [
//                    'attribute' => 'material_id',
//                    'value' => function ($data) {
//                        $material = $data->material;
//                        $html = Html::a(Html::encode($material->material_name ? $material->material_name : $material->id), \yii\helpers\Url::to(['/admin/material/view', 'id' => $material->id])).'<br>';
//                        return $html;
//                    },
//                    'format' => 'raw',
//                    'label' => 'Material name',
//                    'filter' => false
//                ],
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
                    'filter' => [0 => 'Нова', 1 => 'Оброблена'],
//                    'format' => 'boolean',
                    'value' => function ($data) {
                        return $data->status ? 'Оброблена' : 'Нова';
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                ],
            ],
        ]);
    } catch (Exception $e) {
    } ?>
</div>
