<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Archive */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'pdf_file',
            [
                'attribute' => 'pdf_file',
                'value' => function ($model) {
                    if ($model->pdf_file != '')
                        return Html::a(Html::encode('View PDF'), \yii\helpers\Url::to(['/admin/archive/view-pdf', 'id' => $model->id]),['target' => "_blank", 'class' => 'btn btn-primary btn-sm']);
                    return $model->pdf_file;
                },
                'format' => 'raw',
            ],
            'smallImage:image',
            'active:boolean',
        ],
    ]) ?>

</div>
