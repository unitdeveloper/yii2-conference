<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\SearchForm;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--    <base href="http://av.lntu.edu.ua/" />-->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="site com_content view-article no-layout no-task itemid-435">
<script>
    var hoffset= 0;
</script>
<?php $this->beginBody() ?>

<!-- Body -->
<div class="body">
    <div class="container">

        <!-- Header -->
        <header class="header" role="banner">
            <div class="header-inner clearfix">
                <a class="brand pull-left" href="/">
                    <img src="http://av.lntu.edu.ua/images/logo_av.jpg" alt="Конференція «Актуальні проблеми автоматизації та управління»" />											</a>
                <div class="header-search pull-right">

                </div>
            </div>
        </header>
        <nav class="navigation" role="navigation">
            <div class="navbar pull-left">
                <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </div>
            <div class="nav-collapse">
                <div class="well _menu">

                    <?= \yii\widgets\Menu::widget([
                        'options' => ['class' => 'nav menu nav-pills'],
                        'items' => [
                            ['label' => 'Про конференцію', 'url' => ['site/index']],
                            ['label' => 'Матеріали - 2017', 'url' => ['/matherial/index']],
                            ['label' => 'Учасники - 2017', 'url' => ['/participants/index']],
                            ['label' => 'Вимоги до оформлення', 'url' => ['/site/requirements']],
                            ['label' => 'Організатори', 'url' => ['/site/organizers']],
                            ['label' => 'Вихідні дані', 'url' => ['/site/output-data']],
                            ['label' => 'Архів', 'url' => ['/archive/index']],
                            ['label' => 'Ввійти', 'url' => ['auth/login'], 'visible' => Yii::$app->user->isGuest],
                            ['label' => 'Вийти', 'url' => ['auth/logout'], 'visible' => !Yii::$app->user->isGuest],
                        ],
                        'activeCssClass' => 'default current active',
                    ]);
                    ?>
                </div>
            </div>
            <div class="row-fluid">
            <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
            </div>
        <div class="row-fluid">
            <?= $content ?>
        </div>
    </div>
    </div>
</div>
<!-- Footer -->
<footer class="footer" role="contentinfo">
    <div class="container">
        <hr />
        <p class="pull-right">
            <a href="#" id="back-top">Догори</a>
        </p>
        <p>&copy; 2018 Конференція «Актуальні проблеми автоматизації та управління»</p>
    </div>
</footer>


<?php $this->endBody() ?>
<script>
    jQuery(window).on('load',  function() {
        new JCaption('img.caption');
    });
    var HL_open  = false;
    var HLopacity  = 0.9;
    window.setInterval(function(){var r;try{r=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP")}catch(e){}if(r){r.open("GET","/index.php?option=com_ajax&format=json",true);r.send(null)}},840000);
    jQuery(function($){ $(".hasTooltip").tooltip({"html": true,"container": "body"}); });
</script>

<!--<script src="/media/jui/js/html5.js"></script>-->
</body>
</html>
<?php $this->endPage() ?>
