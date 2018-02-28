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

                <table border="0">
                    <tbody>
                    <tr>
                        <?php foreach ($archive as $item) :?>
                        <td>
                            <a href="<?= \yii\helpers\Url::to(['/archive/view-pdf', 'id' => $item->id])?>" target="_blank">
                                <?= \yii\helpers\Html::img('/archive/'.$item->image, ['width' => "226", 'height' => "320"]) ?>
                            </a>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    </tbody>
                </table>

            <div class="attachmentsContainer">

                <div class="attachmentsList" id="attachmentsList_com_content_default_77"></div>

            </div>
        </div>


    </div>

</main>

