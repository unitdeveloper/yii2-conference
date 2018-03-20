<?php

/* @var $this yii\web\View */
/* @var $matherial app\models\Material */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = $matherial->material_name;
?>

<!-- Blog Entries Column -->
<div class="col-md-8">

    <div class="mt-4 mb-4 white_body">
        <h4><?=$matherial->author?></h4>
        <hr>
        <div class="col-md">
            <div class="row meta flex-nowrap">
                <div class="meta-date mr-4">
                    <span class="fa fa-clock-o" aria-hidden="true"></span>
                    <time class="updated" datetime="<?=$matherial->publisher_at?>" itemprop="datePublished" pubdate="">
                        <small><?=Date('F j, Y',strtotime($matherial->publisher_at))?></small>
                    </time>
                </div>
                <?php if (!empty($matherial->category)) : ?>
                    <div class="meta-category mr-4">
                        <span class="fa fa-folder-o" aria-hidden="true"></span>
                        <a href="#" title="Категорія" class="term-1687" data-wpel-link="internal">
                            <small><?= Html::a($matherial->category->name, ['category', 'id' => $matherial->category->id]) ?></small>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md mt-4">
            <div class="row material-header flex-column">
                <span class="f-roboto-c"><?=$matherial->udk?></span>
                <span class="f-roboto-c"><?=$matherial->author?></span>
                <span class="f-roboto-c"><?=$matherial->university?></span>
                <span class="f-roboto-c">e-mail: <?=$matherial->emailHtml?></span>
            </div>
        </div>
        <div class="col-md mt-4">
            <div class="row material-name">
                <h5>
                    <strong>
                        <a href="<?=\yii\helpers\Url::to(['matherial/view', 'id' => $matherial->id])?>">
                            <?=$matherial->material_name?>
                        </a>
                    </strong>
                </h5>
            </div>
        </div>
        <?php if ($matherial->top_tag && $matherial->top_anotation) : ?>
        <div class="col-md mt-4">
            <div class="row material-annotation text-justify">
                <p>
                    <?=$matherial->top_anotation?>
                </p>
                <span>
                    <?=$matherial->top_tag ?>
<!--                    <strong>Ключевые слова:</strong> процессор, компьютер, вычисления, прогнозирование.-->
                </span>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($matherial->second_tag && $matherial->second_annotation) : ?>
        <div class="col-md mt-4">
            <div class="row material-annotation text-justify">
                <p>
                    <?=$matherial->second_annotation?>
                </p>
                <span>
                    <?=$matherial->second_tag?>
                </span>
            </div>
        </div>
        <?php endif;?>
        <?php if ($matherial->last_tag && $matherial->last_annotation) : ?>
        <div class="col-md mt-4">
            <div class="row material-annotation text-justify">
                <p>
                    <?=$matherial->last_annotation?>
                </p>
                <span>
                    <?=$matherial->last_tag?>
                </span>
            </div>
        </div>
        <?php endif; ?>
        <hr>
        <div class="col-md mt-4">
            <span class="fa fa-file-pdf-o mr-1" aria-hidden="true"></span>
            <a href="<?=\yii\helpers\Url::to(['matherial/view-pdf', 'id' => $matherial->id])?>" target="_blank" class="mr-3 material-pdf-link" role="button" aria-disabled="true">
                <small>
                    Повний текст роботи (<?=$matherial->fileSize?>)
                </small>
            </a>
        </div>
        <hr>
        <div class="col-md mt-4 row flex-wrap">
            <?php foreach ($matherial->topTag as $tag) : ?>
            <div class="">
                <span class="fa fa-tag mr-1" aria-hidden="true"></span>
                <a class="mr-2" href="<?=\yii\helpers\Url::to(['/matherial/search', 'SearchForm' => ['q' => $tag, 'type' => 'tag']])?>">
                    <small><?=$tag?></small>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- /.blog-main -->
</div>

<!-- Sidebar Widgets Column -->
<?php try {
    echo \app\widgets\RSidebar::widget();
} catch (Exception $e) {
} ?>

