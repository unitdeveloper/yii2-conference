<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Material', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= \yiister\gentelella\widgets\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'material_name',
            'author',
            [
                'attribute' => 'category_id',
                'filter'    =>  \app\models\Category::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value'     => 'category.name'
            ],
            [
                'attribute' => 'conference_id',
                'filter'    =>  \app\models\Conference::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value'     => 'conference.name'
            ],
//            'category_id',
            [
                'attribute' => 'created_at',
                'value'     => 'created_at',
                'filter'    => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'template' => '{addon}{input}',
                        'clientOptions'=>[
                            'autoclose' => true,
                            'format' => 'yyyy-m-d',
                        ]
                ]),
                'format' => 'date',
            ],
//            'updated_at',
//            'publisher_at',
            [
                'attribute' => 'publisher_at',
                'value'     => 'publisher_at',
                'filter'    => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'publisher_at',
                    'template' => '{addon}{input}',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-d'
                    ],
                ]),
                'format' => 'date',
            ],

            //'university',
            //'email:email',
            //'material_name',
            //'ru_annotation',
            //'ua_annotation',
            //'us_annotation',
            //'ru_tag',
            //'ua_tag',
            //'us_tag',
//            'status_publisher',
            [
                'attribute' => 'status_publisher',
                'filter' => [0 => 'Нет', 1 => 'Да'],
                'format' => 'boolean',
            ],
            //'word_file',
            //'pdf_file',
            //'html_file',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
