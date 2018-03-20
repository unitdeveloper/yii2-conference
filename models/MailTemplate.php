<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%mail_template}}".
 *
 * @property int $id
 * @property string $subject
 * @property string $body
 * @property string $name
 * @property string $slug
 */
class MailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mail_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'body', 'name', 'slug'], 'required'],
            [['body'], 'string'],
            [['subject', 'name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'body' => 'Body',
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }
}
