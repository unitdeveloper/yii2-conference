<?php $model = new \app\models\form\SearchForm(); ?>

<!-- Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Search Widget -->
    <div class="white_body mb-3 mt-4">
        <!--<h5 class="">Пошук</h5>-->
        <div id="custom-search-input">

            <?php $form = \yii\widgets\ActiveForm::begin([
                'action' => \yii\helpers\Url::to(['matherial/search']),
                'method' => 'GET',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{hint}",
                ],
            ]) ?>
            <div class="input-group flex-nowrap justify-content-between">
                <?= $form->field($model, 'q')->textInput(['class' => 'form-control input-lg', 'required' => "required", 'type' => 'search', 'placeholder' => 'Пошук матеріалів'])->label(false); ?>
                <span class="input-group-btn">
                    <button class="btn btn-info btn-lg" type="submit">
                        <i class="fa fa-search glyphicon-search" aria-hidden="true"></i>
                    </button>
                </span>
            </div>
            <?php $form = \yii\widgets\ActiveForm::end(); ?>

        </div>
    </div>

    <?php if ($tags) :?>
    <!-- Categories Widget -->
    <div class="my-3 my-card tags">
        <!--<h5 class="">Теги</h5>-->
        <!--<hr>-->
        <div class="card-header ">Теги</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row pr-3 pl-3 flex-wrap text-capitalize ">
                        <?php /** @var array $tags */
                        foreach ($tags as $tag) : ?>
                        <div class="">
                            <span class="fa fa-tag" aria-hidden="true"></span>
                            <a class="mr-2" href="<?=\yii\helpers\Url::to(['/matherial/search', 'SearchForm' => ['q' => $tag, 'type' => 'tag']])?>">
                                <small><?=$tag?></small>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (!empty($archive)) : ?>
    <!-- Side Widget -->
    <div class="my-card my-3 last-material">
        <!--<h5 class="">Останні матеріали</h5>-->
        <div class="card-header ">Останні матеріали</div>
        <div class="card-body container">
            <div class="row row flex justify-content-center align-items-center">
                <?php foreach ($archive as $item) :?>
                <a href="<?=\yii\helpers\Url::to(['/archive/view-pdf', 'id' => $item->id])?>" target="_blank">
                    <img src="<?=$item->getImage()?>" class="img-fluid mb-2 mr-2 ml-2" />
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
