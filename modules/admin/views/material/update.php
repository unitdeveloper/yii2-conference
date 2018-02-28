<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Material */
if ($model->material_name)
    $this->title = $model->material_name;
else
    $this->title = $model->id;
//$this->title = 'Update Material: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
