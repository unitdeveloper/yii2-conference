<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ParticipantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Participant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'email:email',
            [
                'attribute' => 'material',
                'filter'    =>  false,
                'value' => function ($data) {
                    $materials = $data->materials;
                    if (count($materials) == 0) {
                        return Html::tag('span', 'Матеріали відсутні');
                    }
                    $html = '';
                    foreach ($materials as $material) {
                        if ($material->material_name)
                            $html .= Html::a(Html::encode($material->material_name), \yii\helpers\Url::to(['/admin/material/view', 'id' => $material->id])).'<br>';
                        else
                            $html .= Html::a(Html::encode($material->id), \yii\helpers\Url::to(['/admin/material/view', 'id' => $material->id])).'<br>';
                    }
                    return $html;
                },
                'format' => 'raw',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
