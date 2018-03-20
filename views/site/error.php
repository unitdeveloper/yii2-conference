<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="col-md-12 text-center d-flex justify-content-center">
    <div class="site-error col-md-7 mt-5 white_body">

        <div class="col-middle">
            <div class="text-center text-center">
                <h1 class="error-number"><?= Html::encode($this->title) ?></h1>
                <h2><?= nl2br(Html::encode($message)) ?></h2>
                <p>
                    The above error occurred while the Web server was processing your request.
                </p>
                <p>
                    Please contact us if you think this is a server error. Thank you.
                </p>
            </div>
        </div>

    </div>
</div>