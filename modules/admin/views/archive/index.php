<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ArchiveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Archives';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-index">

    <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Archive', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Create pdf for archive', ['create-pdf'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'pdf_file',
            [
                'attribute' => 'pdf_file',
                'value' => function ($model) {
                    if ($model->pdf_file != '')
                        return Html::a(Html::encode('View PDF'), \yii\helpers\Url::to(['/admin/archive/view-pdf', 'id' => $model->id]),['target' => "_blank", 'class' => 'btn btn-primary btn-sm']);
                    return $model->pdf_file;
                },
                'format' => 'raw',
                'filter' => false,
            ],
//            'image',
            'smallImage:image',
            [
                'attribute' => 'active',
                'filter' => [0 => 'Нет', 1 => 'Да'],
                'format' => 'boolean',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <div class="panel-body">
        <table class="table table-bordered">
            <h5>Created pdf for archive</h5>
            <thead>
            <tr>
                <th>#</th>
                <th>Pdf</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pdfFiles as $key => $file) : ?>
                <tr>
                    <th scope="row"><?=++$key?></th>
                    <td>
                        <div class="row">
                            <div class="col-md-7">
                                <?="<a href=".\yii\helpers\Url::to(['/admin/material/download', 'resource' => $file]).">".str_replace(\Yii::$app->getBasePath() . \Yii::$app->params['PathToAttachments'].'/archive/','',$file)."</a>"?>
                            </div>
                            <div class="col-md-5">
                                <div class="text-right">
                                    <?="<a href=".\yii\helpers\Url::to(['/admin/material/download', 'resource' => $file])." class=\"btn btn-default btn-xs\">Download</a>"?>
                                    <?="<a href=".\yii\helpers\Url::to(['/admin/archive/remove', 'resource' => $file])." class=\"btn btn-dark btn-xs\">Delete File</a>"?>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
