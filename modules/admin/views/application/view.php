<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Application */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-6">
        <p>
        <?php $form = \yii\widgets\ActiveForm::begin(); ?>

        <?= $form->field($model, 'status')->dropDownList(\app\models\Application::getStatusesModeration()); ?>

        <?= $form->field($model, 'created_at')->textInput()->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'participant_id')->textInput()->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'material_id')->textInput()->hiddenInput()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php \yii\widgets\ActiveForm::end(); ?>
        </p>
    </div>

    <div class="col-md-12">
    <?php try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
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
                    'attribute' => 'material_id',
                    'value' => function ($data) {
                        $material = $data->material;
                        if (!$material)
                            return 'Матеріали відсутні';
                        $html = Html::a(Html::encode($material->material_name ? $material->material_name : $material->id), \yii\helpers\Url::to(['/admin/material/view', 'id' => $material->id])) . '<br>';
                        return $html;
                    },
                    'format' => 'raw',
                    'label' => 'Material name',
                ],
                'created_at',
                [
                    'attribute' => 'status',
                    'value' => function ($data) {
                        return $data->statusesModeration[$data->status];
                    },
                ],
            ],
        ]);
    } catch (Exception $e) {} ?>
    </div>
</div>
