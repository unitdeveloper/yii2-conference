<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Participant */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-view">

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
        ],
    ]) ?>

</div>
