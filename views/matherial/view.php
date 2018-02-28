<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = $matherial->material_name;
?>


<main id="content" role="main" class="span9">
    <!-- Begin Content -->

    <div id="system-message-container">
    </div>

    <div class="item-page" itemscope itemtype="https://schema.org/Article">
        <meta itemprop="inLanguage" content="uk-UA" />


        <div itemprop="articleBody">

            <div class="page-header">
                <h2 itemprop="headline"><?=$matherial->author?></h2>
            </div>


            <dl class="article-info muted">


                <dt class="article-info-term">
                </dt>


                <?php if (!empty($matherial->category)) : ?>
                    <dd class="category-name">Категорія: <?= Html::a($matherial->category->name, ['category', 'id' => $matherial->category->id]) ?></dd>
                <?php endif; ?>
                <dd class="published">
                    <i class="far fa-calendar-alt"></i>
                    <time datetime="<?=$matherial->publisher_at?>" itemprop="datePublished">
                        Опубліковано: <?=$matherial->publisher_at?></time>
                </dd>


            </dl>
            <?=$matherial->material_html?>

            <div class="attachmentsContainer">

                <div class="attachmentsList" id="attachmentsList_com_content_article_308">
                    <table>
                        <caption>Вкладення:</caption>
                        <thead>
                        <tr>
                            <th class="at_filename">Файл</th>
                            <th class="at_file_size">Розмір файла:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="odd">
                            <td class="at_filename"><a href="<?=\yii\helpers\Url::to(['matherial/view-pdf', 'id' => $matherial->id])?>" target="_blank">Повний текст роботи</a></td>
                            <td class="at_file_size"><?=$matherial->fileSize?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="content-showtags">
                <ul>
                    <span>Tags: </span>
                    <?=$matherial->topTagHtml?>
                </ul>
            </div>

            <div class="attachmentsContainer">

                <div class="attachmentsList" id="attachmentsList_com_content_default_77"></div>

            </div>
        </div>


    </div>

</main>


<?=\app\widgets\RSidebar::widget()?>

