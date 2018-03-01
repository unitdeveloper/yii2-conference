
<main id="content" role="main" class="span9">
    <!-- Begin Content -->

    <div class="item-page" itemscope itemtype="https://schema.org/Article">
        <meta itemprop="inLanguage" content="uk-UA" />


        <div itemprop="articleBody">
            <?php if($requirementsFragment): ?>
            <h2 itemprop="headline"><?=$requirementsFragment->header?></h2>
            <?=$requirementsFragment->content?>
            <?php endif; ?>

            <?php if($copyrightFragment): ?>
            <h2 itemprop="headline"><?=$copyrightFragment->header?></h2>
            <?=$copyrightFragment->content?>
            <?php endif; ?>
            <div class="attachmentsContainer">

                <div class="attachmentsList" id="attachmentsList_com_content_default_77"></div>

            </div>
        </div>


    </div>

</main>

<?=\app\widgets\RSidebar::widget()?>
