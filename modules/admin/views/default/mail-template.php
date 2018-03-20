<?php
/** @var \app\models\MailTemplate $model */
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Select template</h3>
            <hr>
            <?php foreach ($model as $item) : ?>

            <div class="mt-5">
                <div class="text-center">
                    Subject: <b><?=$item->subject?></b>
                </div>
                <p>
                    <?= $item->body ?>
                </p>
                <div class="col-md-12 text-center">
                    <?= \yii\helpers\Html::a('Select this template', ['/admin'.$path,'id_template' => $item->id]+$params, ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
                <hr>
            <?php endforeach; ?>
        </div>
    </div>
</div>