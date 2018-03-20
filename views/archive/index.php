<?php

/* @var $this yii\web\View */
/* @var $archive app\models\Archive */

$this->title = Yii::$app->name;
?>
<div class="container text-center mt-lg-12 mt-4 mb-4">
    <div class="row flex justify-content-center align-items-center">
        <?php foreach ($archive as $item) :?>
        <div class="cart-archive my-3 mb-3 mr-3 ml-3">
            <a href="<?= \yii\helpers\Url::to(['/archive/view-pdf', 'id' => $item->id])?>" target="_blank">
                <?= \yii\helpers\Html::img('/archive/'.$item->image, ['class' => "img-fluid"]) ?>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>