<?php
/** @var app\models\Application $model */
/* @var $searchModel \app\models\search\ApplicationSearch */
?>
<div class="my-3  material-item">

    <div class="container">
        <div class="meta-date row flex-nowrap justify-content-between align-items-center second-menu">

            <div class="">
                <a href="<?=\yii\helpers\Url::to(['profile/application-view', 'id' => $model->id])?>" title="Автор">
                    <h5><?=$model->first_name?> <?=$model->last_name?></h5>
                </a>
                <div class="small">
                    <span class="fa fa-clock-o" aria-hidden="true"></span>
                    <time class="updated" datetime="<?=$model->created_at?>" itemprop="datePublished" pubdate="<?=$model->created_at?>">
                        <span><?=Date('F j, Y',strtotime($model->created_at))?></span>
                    </time>
                </div>
                <small><b><?=$model->email?></b></small>
                <br>

            </div>

            <div class=" justify-content-end small">
                <span>Матеріали : <b><?= $model->material_id ? 'Наявні' : 'Відсутні'?></b></span>
                <br>
                <span>Статус : <b><?= $model->statusesModeration[$model->status] ?></b></span>
            </div>

        </div>
    </div>

</div>

<!-- /.blog-main -->
