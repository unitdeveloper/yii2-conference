<p class="text-center"><b>Перелік авторів, категорій і тем їх доповідей</b></p>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
        'author',
        [
            'attribute' => 'category_id',
            'value'     => 'category.name'
        ],
        [
            'attribute' => 'material_name',
            'value'     => function($dataProvider) {
                return
                    \yii\helpers\Html::a(\yii\helpers\Html::encode("$dataProvider->material_name"), \yii\helpers\Url::to(['matherial/view', 'id' => $dataProvider->id]));
                },
            'format' => 'raw',
        ],



//        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>