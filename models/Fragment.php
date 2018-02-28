<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%fragment}}".
 *
 * @property int $id
 * @property string $name
 * @property string $header
 * @property string $content
 */
class Fragment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%fragment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['name', 'header'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'header' => 'Header',
            'content' => 'Content',
        ];
    }
}
