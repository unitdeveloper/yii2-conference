<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Application */
/* @var $activeConference app\models\Conference */

$this->title = 'Sign Up Conference';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-lg-5 signup-conference">

    <?php if ($activeConference) : ?>
<!--    <div class="white_body">-->
        <?php $form = ActiveForm::begin([
            'id' => 'form-signup-conference',
            'class' => "form-horizontal",
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>


        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h2>Реєстрація на конференцію</h2>
                <hr>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-users mr-2 mt-2"></i>
                <label for="name">You will register at the conference <b><?=$activeConference->name?></b></label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?php $model->conference_id = $activeConference->id; ?>
                    <?= $form->field($model, 'conference_id')->textInput()->label(false)->hiddenInput() ?>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-user mr-2 mt-2"></i>
                <label for="name">First name</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?php if (!Yii::$app->user->isGuest) $model->first_name = \Yii::$app->user->identity->username ?>
                    <?= $form->field($model, 'first_name')->textInput()->label(false) ?>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-user mr-2 mt-2"></i>
                <label for="name">Last name</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'last_name')->textInput()->label(false) ?>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-user mr-2 mt-2"></i>
                <label for="name">Surname</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'surname')->textInput()->label(false) ?>
                </div>
            </div>

        </div>
        <hr>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-address-card mr-2 mt-2"></i>
                <label for="name">Degree</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'degree')->textInput()->label(false) ?>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-address-card mr-2 mt-2"></i>
                <label for="name">Position</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'position')->textInput()->label(false) ?>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-address-card mr-2 mt-2"></i>
                <label for="name">Work place</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'work_place')->textInput()->label(false) ?>
                </div>
            </div>

        </div>

        <hr>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-map-marker mr-2 mt-2"></i>
                <label for="name">Address speaker</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'address_speaker')->textInput()->label(false) ?>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-phone mr-2 mt-2"></i>
                <label for="name">Phone</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'phone')->textInput()->label(false) ?>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-at  mr-2 mt-2"></i>
                <label for="name">E-Mail адреса</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php if (!Yii::$app->user->isGuest) $model->email = \Yii::$app->user->identity->email ?>
                    <?= $form->field($model, 'email')->textInput()->label(false) ?>
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

        <hr>

        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-header mr-2 mt-2"></i>
                <label for="name">Title report</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'title_report')->textInput()->label(false) ?>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <i class="fa fa-user mr-2 mt-2"></i>
                <label for="name">Surnames co-authors</label>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3 field-label-responsive"></div>
            <br>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'surnames_co_authors')->textInput()->label(false) ?>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 field-label-responsive">
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-success"><i class="fa fa-user-plus"></i>Реєстрація</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
<!--    </div>-->
    <?php else: ?>

        <div class="col-md-12">
            <h2>Активних конференцій на даний момент не існує</h2>
            <hr>
        </div>

    <?php endif; ?>
</div>