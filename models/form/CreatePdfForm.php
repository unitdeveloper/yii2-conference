<?php

namespace app\models\form;


use app\models\Conference;
use yii\base\Model;

class CreatePdfForm extends Model
{
    public $conference_id;

    public function rules()
    {
        return [
            [['conference_id'], 'integer'],
            [['conference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conference_id' => 'id']],
        ];
    }
}