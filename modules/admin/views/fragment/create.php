<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Fragment */

$this->title = 'Create Fragment';
$this->params['breadcrumbs'][] = ['label' => 'Fragments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fragment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
