<?php

use yii\helpers\Html;

$this->title = 'Admin Panel';

?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="row">
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'users',
                'header' => 'Users',
                'text' => 'Count of registered users',
                'number' => $countUsers,
            ]
        )
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'envelope',
                'header' => 'Emails',
                'text' => 'New emails detected',
                'number' => $countNewEmail,
            ]
        )
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'list-alt',
                'header' => 'Material',
                'text' => 'The following material is unpublished',
                'number' => $countUnpublishedMaterial,
            ]
        )
        ?>
    </div>
    <div class="col-xs-12 col-md-3">
        <?=
        \yiister\gentelella\widgets\StatsTile::widget(
            [
                'icon' => 'user',
                'header' => 'Participant',
                'text' => 'Number of participants in the conference',
                'number' => $countParticipant,
            ]
        )
        ?>
    </div>
</div>

<!--<div class="row tile_count">-->
<!--    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
<!--        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>-->
<!--        <div class="count">2500</div>-->
<!--        <span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
<!--    </div>-->
<!--    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
<!--        <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>-->
<!--        <div class="count">123.50</div>-->
<!--        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
<!--    </div>-->
<!--    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
<!--        <span class="count_top"><i class="fa fa-user"></i> Total Males</span>-->
<!--        <div class="count green">2,500</div>-->
<!--        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
<!--    </div>-->
<!--    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
<!--        <span class="count_top"><i class="fa fa-user"></i> Total Females</span>-->
<!--        <div class="count">4,567</div>-->
<!--        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>-->
<!--    </div>-->
<!--    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
<!--        <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>-->
<!--        <div class="count">2,315</div>-->
<!--        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
<!--    </div>-->
<!--    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">-->
<!--        <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>-->
<!--        <div class="count">7,325</div>-->
<!--        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>-->
<!--    </div>-->
<!--</div>-->
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Action</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
<!--                    <li class="dropdown">-->
<!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>-->
<!--                        <ul class="dropdown-menu" role="menu">-->
<!--                            <li><a href="#">Settings 1</a>-->
<!--                            </li>-->
<!--                            <li><a href="#">Settings 2</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </li>-->
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <a class="btn btn-app" href="<?=\yii\helpers\Url::to(['/admin/default/reader-email'])?>">
                    <span class="badge bg-orange"><?=$countNewEmail?></span>
                    <i class="fa fa-envelope"></i> Read Email
                </a>
                <a class="btn btn-app" href="<?=\yii\helpers\Url::to(['/admin/default/mailing'])?>">
                    <i class="fa fa-envelope"></i> Mailing
                </a>
<!--                'label' => 'Read emails (max '.\Yii::$app->config->get('EMAIL_READING_LIMIT').')',-->
            </div>
        </div>
    </div>
</div>
