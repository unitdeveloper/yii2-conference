<?php

namespace app\models\form;


use yii\base\Model;

class MailingForm extends Model
{
    public $body;
    public $subject;

    public function rules()
    {
        return [
            [['body', 'subject'], 'string'],
            [['body', 'subject'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'body' => 'Body message',
            'subject' => 'Subject',
        ];
    }

}