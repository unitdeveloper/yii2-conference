<?php
/** @var app\models\Application $model */
/* @var $searchModel \app\models\search\ApplicationSearch */
?>
<div class="my-3  material-item">

    <div class="container">
        <div class="meta-date row flex-nowrap justify-content-between align-items-center second-menu">
            <a href="<?=\yii\helpers\Url::to(['profile/application', 'id' => $model->id])?>" title="Автор">
            <div class="">
                <span class="fa fa-clock-o" aria-hidden="true"></span>
                <time class="updated" datetime="<?=$model->created_at?>" itemprop="datePublished" pubdate="<?=$model->created_at?>">
                    <small><?=Date('F j, Y',strtotime($model->created_at))?></small>
                </time>
            </div>
            </a>

            <div class="d-flex justify-content-end align-items-center small">
                <span><?= $model->status ?></span>
            </div>

        </div>
    </div>

</div>

<!-- /.blog-main -->
