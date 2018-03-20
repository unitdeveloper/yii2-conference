<?php

/* @var $this yii\web\View */
/* @var $fragment app\models\Fragment */

$this->title = Yii::$app->name;
?>

<!-- Blog Entries Column -->
<div class="col-md-8">
    <?php if($fragment): ?>
        <div class="my-3 mt-4 white_body material-item">
            <h4 class="border-bottom pb-3">
                <?=$fragment->header?>
            </h4>
            <div class="participant-table mt-4">
                <?=$fragment->content?>
            </div>
        </div>
    <?php endif; ?>

</div>


<?=\app\widgets\RSidebar::widget()?>

