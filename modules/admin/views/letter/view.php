<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Letter */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Letters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($model->status == 0) : ?>
            <?= Html::a('Відмітити як: Оброблена', ['change-status', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php else: ?>
            <?= Html::a('Відмітити як: Нова', ['change-status', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            [
                'attribute' =>  'participant_id',
                'value' => function ($data) {
                    $participant = $data->participant;
                    $html = Html::a(Html::encode($participant->email), \yii\helpers\Url::to(['/admin/participant/view', 'id' => $participant->id])).'<br>';
                    return $html;
                },
                'format' => 'raw',
                'label' => 'Participant email'
            ],
            [
                'attribute' =>  'material_id',
                'value' => function ($data) {
                    $material = $data->material;
                    if (!$material)
                        return 'Матеріали відсутні';
                    $html = Html::a(Html::encode($material->material_name ? $material->material_name : $material->id), \yii\helpers\Url::to(['/admin/material/view', 'id' => $material->id])).'<br>';
                    return $html;
                },
                'format' => 'raw',
                'label' => 'Material name',
            ],
            'created_at',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data->status ? 'Оброблена' : 'Нова';
                },
            ],
            'message:html'
        ],
    ]) ?>

</div>
