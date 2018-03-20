<?php

/* @var $this yii\web\View */
/* @var $fragment app\models\Fragment */

$this->title = Yii::$app->name;
?>

<!-- Blog Entries Column -->
<div class="col-md-8">

    <div class="head blog-title mt-4 bg-dark">
    <h3 class="">Актуальні проблеми автоматизації та управліня</h3>
    <small class="lead my-3 f-roboto-c">Міжнародна науково-практична інтернет-коференція молодих учених та студентів</small>
    </div>
<!--    <div class="head mt-4">-->
<!--        <img src="http://av.lntu.edu.ua/images/logo_av.jpg" class="img-fluid" alt="">-->
<!--    </div>-->
    <?php if($fragment): ?>
    <main class="my-3 white_body">
        <div class="blog-main">
            <h4 class="border-bottom pb-3">
                <?= $fragment->header ?>
            </h4>

            <div class="blog-post">

                <?= $fragment->content ?>
            </div>

        </div>
        <!-- /.blog-main -->
    </main>
    <?php endif; ?>
</div>

<!-- Sidebar Widgets Column -->
<?=\app\widgets\RSidebar::widget()?>

