<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Material */
if ($model->material_name) {

    $this->title = $model->material_name;
} else {

    $this->title = $model->id;
}

$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>


    <p>
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group margin-right" role="group" aria-label="First group">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
            <div class="btn-group mr-5" role="group" aria-label="Second group">
                <?= Html::a('Conversion | Parsing', ['parsing', 'id' => $model->id], ['class' => 'btn btn-dark']) ?>
                <?= Html::a('Conversion', ['conversion', 'id' => $model->id], ['class' => 'btn btn-dark']) ?>
            </div>
            <?php if ($model->participant_id) : ?>
            <div class="btn-group mr-5" role="group" aria-label="Last group">
                <?= Html::a('View Sender', ['/admin/participant/view', 'id' => $model->participant_id], ['class' => 'btn btn-default']) ?>
            </div>
            <?php endif; ?>
        </div>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'category_id',
            [
                'attribute' =>  'category_id',
                'value' =>  \yii\helpers\ArrayHelper::getValue($model, 'category.name'),
            ],
            [
                'attribute' =>  'conference_id',
                'value' =>  \yii\helpers\ArrayHelper::getValue($model, 'conference.name'),
            ],
            'created_at',
            'updated_at',
            'publisher_at',
            'udk',
            'author',
            'university',
            'emailHtml:html',
            'material_name',
            'ru_annotation:html',
            'ru_tag:html',
            'ua_annotation:html',
            'ua_tag:html',
            'us_annotation:html',
            'us_tag:html',
            'top_anotation:html',
            'top_tag:html',
            'material_html:html',
            'status_publisher:boolean',
            'dir',
            'word_file',
            [
                'attribute' => 'pdf_file',
                'value' => function ($model) {
                    if ($model->pdf_file != '')
                        return Html::a(Html::encode('View PDF'), \yii\helpers\Url::to(['/admin/material/view-pdf', 'id' => $model->id]),['target' => "_blank", 'class' => 'btn btn-primary btn-sm']);
                    return $model->pdf_file;
                },
                'format' => 'raw',
            ],
            'html_file',
        ],
    ]) ?>

</div>
