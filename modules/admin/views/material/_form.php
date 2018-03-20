<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Material */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
if ($model->pdf_file != '')
    echo Html::a(Html::encode('View PDF'), \yii\helpers\Url::to(['/admin/material/view-pdf', 'id' => $model->id]),['target' => "_blank", 'class' => 'btn btn-primary btn-sm']);
?>
<br>
<br>
<div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(\app\models\Category::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => '']) ?>

    <?= $form->field($model, 'conference_id')->dropDownList(\app\models\Conference::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => '']) ?>

    <?php $form->field($model, 'created_at')->widget(
            \dosamigos\datepicker\DatePicker::className(), [
            'inline' => false,
            'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d',
            ]
    ]); ?>

    <?= $form->field($model, 'udk')->textInput() ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'university')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'material_name')->textInput(['maxlength' => true]) ?>

    <hr>
    <hr>

    <?= $form->field($model, 'top_anotation')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 80,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);?>

    <?= $form->field($model, 'top_tag')->textInput(['maxlength' => true]) ?>

    <hr>
    <hr>

    <?= $form->field($model, 'second_annotation')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 80,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);?>

    <?= $form->field($model, 'second_tag')->textInput(['maxlength' => true]) ?>

    <hr>
    <hr>

    <?= $form->field($model, 'last_annotation')->widget(\vova07\imperavi\Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 80,
            'plugins' => [
                'clips',
                'fullscreen',
            ],
        ],
    ]);?>

    <?= $form->field($model, 'last_tag')->textInput(['maxlength' => true]) ?>

    <hr>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Завантажити word файл
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="card card-body">
                        <?php if($model->word_file) : ?>
                            <?= $form->field($model, 'wordFile')->widget(\kartik\file\FileInput::classname(), [
                                    'options' => ['accept' => 'file/*'],
                                    'pluginOptions' => [
                                        'showCaption' => true,
                                        'showRemove' => true,
                                        'showUpload' => false,
                                        'initialPreview'=>[
                                            $model->word_file ? Html::tag('i', '',
                                            ['class' => 'glyphicon glyphicon-file',
                                            'style' => "font-size: 6em;padding-top: 10px;"
                                            ]).
                                            '<br>'.
                                            Html::tag('span', $model->word_file, ['style' => "
                                            display: block;
                                            text-align: center;
                                            padding-top: 9px;
                                            font-size: 11px;
                                            color: #777;
                                            margin-bottom: 15px;
                                            "]) : null
                                        ],
                                    ]
                            ])?>
                        <?php else : ?>
                            <?= $form->field($model, 'wordFile')->widget(\kartik\file\FileInput::classname(), [
                                'options' => ['accept' => 'file/*'],
                                'pluginOptions' => [
                                    'showCaption' => true,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                ]
                            ])?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        Вказати файл на сервері
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <?php
                    \yiister\gentelella\widgets\Panel::begin(['header' => 'Структура директорії',]) ?>
                    <?php if ($structure = $model->getDirStructure()) : ?>
                        <p><?= $structure ?></p>
                    <?php else: ?>
                        <p>...</p>
                    <?php endif; ?>
                    <?php \yiister\gentelella\widgets\Panel::end() ?>
                    <?= $form->field($model, 'word_file')->textInput(['maxlength' => true, 'placeholder' => 'example.doc']) ?>
                </div>
            </div>
        </div>
    </div>


    <?= $form->field($model, 'status_publisher')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?php
            if ($model->pdf_file != '')
                echo Html::a(Html::encode('View PDF'), \yii\helpers\Url::to(['/admin/material/view-pdf', 'id' => $model->id]),['target' => "_blank", 'class' => 'btn btn-primary']);
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
