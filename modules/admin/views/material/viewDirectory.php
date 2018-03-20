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
$this->params['breadcrumbs'][] = 'View Directory';
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                Директорія - <?= $model->dir ?>
            </a>
        </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in">
        <div class="panel-body">

            <?php if ($structure = $model->getDirStructure()) : ?>
                <p><?= $structure ?></p>
            <?php else: ?>
                <p>...</p>
            <?php endif; ?>

        </div>
    </div>
</div>
