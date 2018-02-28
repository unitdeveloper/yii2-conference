
<main id="content" role="main" class="span9">
    <!-- Begin Content -->

    <div class="item-page" itemscope itemtype="https://schema.org/Article">
        <meta itemprop="inLanguage" content="uk-UA" />


        <div itemprop="articleBody">

            <h2 itemprop="headline"><?=$requirementsFragment->header?></h2>
            <?=$requirementsFragment->content?>

            <p style="text-align: justify;">
                <strong>Матеріали надсилаються на пошту конференції **** із позначкою «Конференція».</strong>
            </p>
            <p style="text-align: justify;">
                <strong>
                    <a href="<?=\yii\helpers\Url::to(['/site/download', 'resource' => 'IM_ua_1.docx'])?>">Завантажити ІНФОРМАЦІЙНЕ ПОВІДОМЛЕННЯ та ЗАЯВКУ НА УЧАСТЬ</a>
                    <br/>
                </strong>
                <strong>
                    <a href="<?=\yii\helpers\Url::to(['/site/download', 'resource' => 'IM_ru_1.docx'])?>">Скачать ИНФОРМАЦИОННОЕ СООБЩЕНИЕ и ЗАЯВКУ НА УЧАСТИЕ</a>
                    <br/>
                </strong>
                <strong>
                    <a href="<?=\yii\helpers\Url::to(['/site/download', 'resource' => 'IM_us_1.docx'])?>">Download notification and application for participation</a>
                    <br/>
                </strong>
                <strong>
                    <a href="<?=\yii\helpers\Url::to(['/site/download', 'resource' => 'IM_pl_1.docx'])?>">Pobierz ogłoszenie i wniosków o dopuszczenie do udziału</a>
                </strong>
            </p>

            <h2 itemprop="headline"><?=$copyrightFragment->header?></h2>
            <?=$copyrightFragment->content?>

            <div class="attachmentsContainer">

                <div class="attachmentsList" id="attachmentsList_com_content_default_77"></div>

            </div>
        </div>


    </div>

</main>

<?=\app\widgets\RSidebar::widget()?>
