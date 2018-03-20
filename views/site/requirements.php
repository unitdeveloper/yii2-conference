<?php

/* @var $this yii\web\View */
/* @var $requirementsFragment app\models\Fragment */
/* @var $copyrightFragment app\models\Fragment */

$this->title = Yii::$app->name;
?>

<!-- Blog Entries Column -->
<div class="col-md-8">
    <?php if($requirementsFragment): ?>
        <div class="my-3 mt-4 white_body material-item">
            <h4 class="border-bottom pb-3">
                <?=$requirementsFragment->header?>
            </h4>
            <div class="participant-table mt-4">
                <?=$requirementsFragment->content?>
            </div>
        </div>
    <?php endif; ?>

    <?php if($copyrightFragment): ?>
        <div class="my-3 white_body material-item">
            <h4 class="border-bottom pb-3">
                <?=$copyrightFragment->header?>
            </h4>
            <div class="participant-table mt-4">
                <?=$copyrightFragment->content?>
            </div>
        </div>
    <?php endif; ?>

</div>


<?=\app\widgets\RSidebar::widget()?>
