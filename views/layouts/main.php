<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- Required meta tags -->
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?= Html::csrfMetaTags() ?>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&amp;subset=cyrillic" rel="stylesheet">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<header class="blog-header py-3 text-white fixed-top bg-dark">
    <div class="container">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-5">
                <span class="fa fa-graduation-cap mr-1" aria-hidden="true"></span>
                <?=Html::a('Конференція - 2018', ['site/index'], ['class' => 'text-white logo'])?>
            </div>
            <div class="col-sm d-flex justify-content-end align-items-center">
<!--                <div>-->
<!--                    <a href="#" onclick="doGTranslate('uk|uk');return false;" title="Ukrainian" class="btn btn-sm pl-0 pr-1 flag nturl --><?php //if (!isset($_COOKIE["googtrans"])) echo 'active'; ?><!-- ">ua</a>-->
<!--                    <a href="#" onclick="doGTranslate('uk|en');return false;" title="English" class="btn btn-sm pl-0 pr-1 flag nturl --><?php //if (isset($_COOKIE["googtrans"]) && $_COOKIE["googtrans"] == '/uk/en') echo 'active'; ?><!--">en</a>-->
<!--                    <a href="#" onclick="doGTranslate('uk|pl');return false;" title="Polish" class="btn btn-sm pl-0 pr-1 flag nturl --><?php //if (isset($_COOKIE["googtrans"]) && $_COOKIE["googtrans"] == '/uk/pl') echo 'active'; ?><!--">po</a>-->
<!--                    <a href="#" onclick="doGTranslate('uk|ru');return false;" title="Russian" class="btn btn-sm pl-0 pr-1 flag nturl --><?php //if (isset($_COOKIE["googtrans"]) && $_COOKIE["googtrans"] == '/uk/ru') echo 'active'; ?><!--">ru</a>-->
<!--                    |-->
<!--                </div>-->
                <?php if (Yii::$app->user->isGuest) : ?>
                <?=Html::a('Увійти', ['auth/login'], ['class' => 'btn btn-sm text-white font-weight-bold'])?>
                <span class="fa fa-sign-in mr-2" aria-hidden="true"></span>

                <?=Html::a('Зареєструватися', ['auth/signup'], ['class' => 'btn btn-sm btn-outline-secondary text-white'])?>
                <?php elseif (!Yii::$app->user->isGuest) : ?>
                    <?=Html::a('Вийти', ['auth/logout'], ['class' => 'btn btn-sm text-white font-weight-bold'])?>
                    <span class="fa fa-sign-out mr-2" aria-hidden="true"></span>
                <small>(<?=Yii::$app->user->identity->username?>)</small>
                <?php endif;?>
            </div>
        </div>


        <div class="row flex-nowrap justify-content-between align-items-center second-menu">
            <div class="col-lg menu-item">
                <?php try {
                        echo \yii\widgets\Menu::widget([
                        'options' => ['class' => 'nav menu nav-pills'],
                        'items' => [
                            ['label' => 'Конференція', 'url' => ['site/index']],
                            ['label' => 'Матеріали', 'url' => ['/matherial/index']],
                            ['label' => 'Учасники', 'url' => ['/participants/index']],
                            ['label' => 'Вимоги до оформлення', 'url' => ['/site/requirements']],
                            ['label' => 'Організатори', 'url' => ['/site/organizers']],
                            ['label' => 'Вихідні дані', 'url' => ['/site/output-data']],
                            ['label' => 'Архів', 'url' => ['/archive/index']],
                            ['label' => 'Контакти', 'url' => ['/site/contact']],
                        ],
                        'labelTemplate' => '{label} Label',
                        'linkTemplate' => '<a href="{url}" class="pt-2 pb-2 pr-2 "><span>{label}</span></a>',
                        'activeCssClass' => 'menu-active',
                    ]);
                } catch (Exception $e) {
                }
                ?>
            </div>
            <?php if (!\Yii::$app->user->isGuest) : ?>
            <div class="d-flex justify-content-end align-items-center small">
                <?=Html::a('Зареєструватися на конференцію', ['auth/signup-conference'], ['class' => 'btn btn-sm text-white'])?>
            </div>
            <?php $application = \app\models\Application::find()->where(['user_id' => \Yii::$app->user->id])->count(); ?>
                <?php if ($application) : ?>
                |
                    <?=Html::a('My application', ['profile/application'],  ['class' => 'btn btn-sm text-white'])?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="container pt-2">

    <div class="row-fluid">
        <?php try {
            echo \yii2mod\alert\Alert::widget();
        } catch (Exception $e) {
        } ?>
    </div>

    <div class="row">
        <?=$content?>
    </div>
    <!-- /.row -->

</div>

<footer class="blog-footer mt-5">
    <p>
        <a href="#"></a>
    </p>
</footer>
<?php $this->endBody() ?>

<!--<div id="google_translate_element2"></div>-->
<!--<script type="text/javascript">function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'uk', autoDisplay: false}, 'google_translate_element2');}</script>-->
<!--<script type="text/javascript" src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>-->

</body>

</html>
<?php $this->endPage() ?>
