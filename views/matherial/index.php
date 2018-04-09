<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $q string */
/* @var $searchModel \app\models\search\MaterialFrontSearch */
/* @var $model \app\models\form\SearchForm */

?>

<!-- Blog Entries Column -->
<div class="col-md-8">

    <?php //\yii\widgets\Pjax::begin(); ?>
    <?php $form = \yii\widgets\ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
        'id' => 'materialFilterForm',
    ]); ?>
    <?php if (isset($model->q)) : ?>
        <?php if ($model->q) : ?>
            <div class="white_body mt-4">
                <span>По вашому запиту
                    <b>"<?=trim($model->q)?>"</b>
                    знайдено <b><?=$dataProvider->getTotalCount()?></b> матеріала(ів)
                </span>
                <a class="ml-1" href="<?=\yii\helpers\Url::to(['matherial/index'])?>">
                    <svg aria-hidden="true" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="gray5 absolute center-v right-1 pointer hover-red5 svg-inline--fa fa-times-circle fa-w-16 fa-fw fa-lg" style=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" class=""></path></svg>
                </a>
            </div>
        <?php else : ?>
            <div class="white_body mt-4">
                <span>Пошуковий запит не повинен бути порожнім</span>
                <a class="ml-1" href="<?=\yii\helpers\Url::to(['matherial/index'])?>">
                    <svg aria-hidden="true" data-prefix="fas" data-icon="times-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="gray5 absolute center-v right-1 pointer hover-red5 svg-inline--fa fa-times-circle fa-w-16 fa-fw fa-lg" style=""><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" class=""></path></svg>
                </a>
            </div>
        <?php endif; ?>
    <?php else :?>
        <?php if ($conference =  \app\models\Conference::find()->select(['name', 'id'])->indexBy('id')->column()) : ?>

            <div class="head blue_body mt-4 bg-dark conference-card">
                <?= $form->field($searchModel, 'conference_id')->
                radioList(
                    [null =>'Всі матеріали'] + $conference,
                    [
                        'inline'=>true,
                        'onchange' => 'submit();',
                        'item' => function($index, $label, $name, $checked, $value) {
                            $return = '<label class="modal-radio">';
                            if ($checked)
                                $return .= '<input class="invisible" type="radio" name="' . $name . '" value="' . $value . '"checked tabindex="3">';
                            else
                                $return .= '<input class="invisible" type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                            if ($checked)
                                $return .= '<span class=" active btn btn-sm btn-outline-secondary active-i border-0">'. ucwords($label) .'</span>';
                            else
                                $return .= '<span class="btn btn-sm btn-outline-secondary active-i border-0">'. ucwords($label) .'</span>';
                            $return .= '</label>';

                            return $return;
                        },
                    ]
                )->label(false) ?>

                <?php
                if ($searchModel->conference_id)
                    $category = \app\models\Category::find()->where(['conference_id' => $searchModel->conference_id])->select(['name', 'id'])->indexBy('id')->column();
                else
                    $category = \app\models\Category::find()->select(['name', 'id'])->indexBy('id')->column();
                ?>
                <?php if ($category) : ?>

                <hr>

                <a id="category-collapse" class="btn btn-sm btn-outline-secondary active-i border-0 text-white" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Категорії
                </a>
                <div class="collapse" id="collapseExample">
                    <hr>
                    <?= $form->field($searchModel, 'category_id')->
                    radioList(
                        [null =>'Всі категорії'] + $category,
                        [
                            'inline'=>true,
                            'onchange' => 'submit();',
                            'item' => function($index, $label, $name, $checked, $value) {
                                $return = '<label class="modal-radio category-label">';
                                if ($checked)
                                    $return .= '<input class="invisible cursor-p" type="radio" name="' . $name . '" value="' . $value . '"checked tabindex="3">';
                                else
                                    $return .= '<input class="invisible cursor-p" type="radio" name="' . $name . '" value="' . $value . '" tabindex="3">';
                                if ($checked)
                                    $return .= '<span class="active cursor-p fa fa-folder-o mr-1"></span><small class="cursor-p">'. ucwords($label) .'</small>';
                                else
                                    $return .= '<span class="cursor-p text-dark fa fa-folder-o mr-1"></span><small class="text-d cursor-p">'. ucwords($label) .'</small>';
                                $return .= '</label>';
                                $return .= '<br>';
                                return $return;
                            },
                        ]
                    )->label(false) ?>
                </div>
                <?php endif; ?>
            </div>


        <?php endif; ?>
    <?php endif; ?>

        <?php try {
            echo \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_materialItem',
                'viewParams' => ['form' => $form, 'searchModel' => $searchModel],
                'emptyText' => '<div class="my-3 white_body material-item">Матеріалів не знайдено</div>',
                'layout' => "{items}\n{pager}",
                'pager' => [
                    'firstPageLabel' => 'Перша',
                    'lastPageLabel'  => 'Остання',
                    'prevPageLabel'  => 'Попередня',
                    'nextPageLabel'  => 'Наступна',
                    'maxButtonCount' => 5,

                    // Customzing CSS class for pager link
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active',
                    'disabledPageCssClass' => 'disabled',

                    // Customzing CSS class for navigating link
                    'prevPageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item',
                    'firstPageCssClass' => 'page-item',
                    'lastPageCssClass' => 'page-item',
                ],
            ]);
        } catch (Exception $e) {
        } ?>
    <?php \yii\widgets\ActiveForm::end(); ?>
    <?php //\yii\widgets\Pjax::end(); ?>
</div>

<!-- Sidebar Widgets Column -->
<?php try {
    echo \app\widgets\RSidebar::widget();
} catch (Exception $e) {
} ?>

<?php // echo Html::dropDownList('Hi', 'w', \yii\helpers\ArrayHelper::getValue($conferences, function ($conferences, $defaultValue) {
//        $arr = [];
//        foreach ($conferences as $conference) {
//            $arr[\yii\helpers\Url::to(['/matherial/conference', 'id' => $conference->id])] = $conference->name;
//        }
//        return $arr;
//    }), ['onchange' => "window.location.href=this.options[this.selectedIndex].value", 'prompt' => 'Конференции', 'options' => [yii\helpers\Url::current([]) => ['Selected' => true]]]) ?>
