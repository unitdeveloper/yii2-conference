<?php

/* @var $this yii\web\View */
/* @var $model \app\models\Application */


$this->title = Yii::$app->name;
?>


<div class="col-md-12">
    <div class="my-3 mt-4 white_body material-item">
        <h4 class="border-bottom pb-3">
            My application (<?=Yii::$app->user->identity->username?>)
        </h4>
        <div class="participant-table mt-4">
            <h5><?=$model->first_name?> <?=$model->last_name?></h5>
            <small><b><?=$model->email?></b></small>
            <br>
            <span class="fa fa-clock-o" aria-hidden="true"></span>
            <time class="updated" datetime="<?=$model->created_at?>" itemprop="datePublished" pubdate="<?=$model->created_at?>">
                <small><?=Date('F j, Y',strtotime($model->created_at))?></small>
            </time>
            <br>
            <br>
            <p>
                <?php if (!$model->material_id) : ?>
                    <a href="<?=\yii\helpers\Url::to(['profile/application-material', 'id' => $model->id])?>" title="Завантажити матеріали" class="btn btn-light"><small>Завантажити матеріали</b></small></a>
                <?php endif; ?>
                <?php if (!$model->status) : ?>
                    <a href="<?=\yii\helpers\Url::to(['profile/application-delete', 'id' => $model->id])?>" title="Видалити заявку" class="btn btn-light"><small>Видалити заявку</b></small></a>
                <?php endif; ?>
            </p>
            <small>Матеріали : <b><?= $model->material_id ? 'Наявні' : 'Відсутні'?></b></small>
            |
            <small>Статус : <b><?= $model->statusesModeration[$model->status] ?></b></small>
        </div>
    </div>
</div>