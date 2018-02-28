<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>

<main id="content" role="main" class="span9">
    <!-- Begin Content -->

    <div id="system-message-container">
    </div>

    <div class="item-page" itemscope itemtype="https://schema.org/Article">
        <meta itemprop="inLanguage" content="uk-UA" />


        <div itemprop="articleBody">
            <?=$fragment->content?>
            <div class="attachmentsContainer">

                <div class="attachmentsList" id="attachmentsList_com_content_default_77"></div>

            </div>
        </div>


    </div>

</main>

<?=\app\widgets\RSidebar::widget()?>

