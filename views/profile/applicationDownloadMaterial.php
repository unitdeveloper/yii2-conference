<?php
/** @var app\models\Application $model */
/* @var $searchModel \app\models\search\ApplicationSearch */
?>
<div class="col-md-12">
    <div class="my-3 mt-4 white_body material-item">
        <h4 class="border-bottom pb-3">
            Завантажити матеріали (admin)
        </h4>
        <?php if (!$model->material_id) : ?>
        <span>Ви можете відправити всі матеріали з вашого емейла <b><?=$model->email?></b> на пошту <b><?=\Yii::$app->config->get('ADMIN_EMAIL');?></b></span>
        <p>або завантажте їх нижче</p>
        <div class="participant-table mt-4">
            <?php $form = \yii\widgets\ActiveForm::begin([
                'id' => 'form-signup-conference',
                'class' => "form-horizontal",
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>
            <div class="row">
                <div class="col-md-4">
                <?= $form->field($applicationForm, 'category_id')->dropDownList(\app\models\Category::find()->where(['conference_id' => $model->conference_id])->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => '']) ?>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <i class="fa fa-file-word-o  mr-2 mt-2"></i>
                    <label for="name">Файл заявки</label>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <?=$form->field($applicationForm, 'application_file')->fileInput()->label(false);?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <!-- Put name validation error messages here -->
                    </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <i class="fa fa-file-word-o  mr-2 mt-2"></i>
                    <label for="name">Файл статті</label>
                </div>

            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <?=$form->field($applicationForm, 'article_file')->fileInput()->label(false);?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                    <span class="text-danger align-middle">
                        <!-- Put name validation error messages here -->
                    </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?= $form->field($applicationForm, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-outline-dark"><i class="fa fa-file"></i> Завантажити</button>
                </div>
            </div>
            <?php \yii\widgets\ActiveForm::end(); ?>
        </div>
        <?php else: ?>
        <span>Матеріали завантажені</span>
        <?php endif; ?>
    </div>
</div>

<!-- /.blog-main -->
