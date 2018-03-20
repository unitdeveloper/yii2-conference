
<!-- Blog Entries Column -->
<div class="col-md-12">

    <div class="my-3 mt-4 white_body material-item">
        <h4 class="border-bottom pb-3">
            Перелік авторів, категорій і тем їх доповідей
        </h4>
        <div class="participant-table mt-4">
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
            'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
                [
                    'attribute' => 'author',
                    'label'     => 'Автор (автори)',
                ],
                [
                    'attribute' => 'category_id',
                    'value'     => 'category.name',
                    'label'     => 'Категорія',
                ],
                [
                    'attribute' => 'material_name',
                    'value'     => function($dataProvider) {
                        return
                            \yii\helpers\Html::a(\yii\helpers\Html::encode("$dataProvider->material_name"), \yii\helpers\Url::to(['matherial/view', 'id' => $dataProvider->id]));
                    },
                    'format' => 'raw',
                    'label'     => 'Доповідь',
                ],



//        ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        </div>
    </div>

</div>
