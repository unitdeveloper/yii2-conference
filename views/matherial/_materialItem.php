<?php
/** @var app\models\Material $model */
/* @var $searchModel \app\models\search\MaterialFrontSearch */
?>
<div class="my-3 white_body material-item">

    <a href="<?=\yii\helpers\Url::to(['matherial/view', 'id' => $model->id])?>" title="Автор">
        <h4><?= $model->author?></h4>
    </a>
    <hr>
    <div class="col-md">
        <div class="row meta flex-nowrap">
            <div class="meta-date mr-4">
                <span class="fa fa-clock-o" aria-hidden="true"></span>
                <time class="updated" datetime="<?=$model->publisher_at?>" itemprop="datePublished" pubdate="<?=$model->publisher_at?>">
                    <small><?=Date('F j, Y',strtotime($model->publisher_at))?></small>
                </time>
            </div>
            <?php if (!empty($model->category)) : ?>
                <div class="meta-category mr-4">
                    <span class="fa fa-folder-o" aria-hidden="true"></span>
                    <small><?php echo $model->category->name ?></small>
                </div>

            <?php endif; ?>
        </div>
    </div>
    <div class="col-md mt-4">
        <div class="row material-header flex-column">
            <span class="f-roboto-c"><?=$model->udk?></span>
            <span class="f-roboto-c"><?=$model->author?></span>
            <span class="f-roboto-c"><?=$model->university?></span>
            <span class="f-roboto-c">e-mail: <?=$model->emailHtml?></span>
        </div>
    </div>
    <div class="col-md mt-4">
        <div class="row material-name">
            <h5>
                <strong>
                    <a href="<?=\yii\helpers\Url::to(['matherial/view', 'id' => $model->id])?>">
                        <?=$model->material_name?>
                    </a>
                </strong>
            </h5>
        </div>
    </div>
    <div class="col-md mt-4">
        <div class="row material-annotation text-justify">
            <?=$model->top_anotation?>
        </div>
    </div>
    <div class="col-md mt-4">
        <div class="row material-view flex-nowrap justify-content-between align-items-center">
            <a href="<?=\yii\helpers\Url::to(['matherial/view', 'id' => $model->id])?>" class="btn btn-outline-dark mr-3" role="button" aria-disabled="true">Детальніше</a>
<!--            <div class="material-attachments">-->
<!--                <span class="fa fa-file-pdf-o mr-1" aria-hidden="true"></span>-->
<!--                <a href="--><?php //echo \yii\helpers\Url::to(['matherial/view-pdf', 'id' => $model->id])?><!--" target="_blank" class="mr-3 material-pdf-link" role="button" aria-disabled="true">-->
<!--                    <small>-->
<!--                        Повний текст роботи (--><?php //echo $model->fileSize?><!--)-->
<!--                    </small>-->
<!--                </a>-->
<!--            </div>-->
        </div>
    </div>
</div>

<!-- /.blog-main -->
