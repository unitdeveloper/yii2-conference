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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
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
    ]); ?>
</div>
