<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Config */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'param',
            'label',
            [
                'attribute' => 'value',
                'value' => function ($model) {
                    return $model->getValue();
                },
                'format' => 'html',
            ],
//            'default:ntext',
            //'type',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
