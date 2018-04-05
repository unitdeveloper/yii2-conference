<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $searchModel \app\models\search\ApplicationSearch */


$this->title = Yii::$app->name;
?>


<div class="col-md-12">
        <div class="my-3 mt-4 white_body material-item">
            <h4 class="border-bottom pb-3">
                My application (<?=Yii::$app->user->identity->username?>)
            </h4>
            <div class="participant-table mt-4">
                <?php try {
                    echo \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => '_applicationItem',
//                        'viewParams' => ['form' => $form, 'searchModel' => $searchModel],
                        'emptyText' => 'Заявки відсутні',
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
            </div>
        </div>
</div>