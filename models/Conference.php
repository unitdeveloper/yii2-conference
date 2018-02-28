<?php

namespace app\models;

use app\models\job\RemoveMaterialDirJob;
use Yii;

/**
 * This is the model class for table "{{%conference}}".
 *
 * @property int $id
 * @property string $name
 */
class Conference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%conference}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['conference_id' => 'id']);
    }

    public function beforeDelete()
    {
        $materials = $this->materials;

        \Yii::$app->queue->push(new RemoveMaterialDirJob([
            'materials' => $materials,
        ]));

        return parent::beforeDelete();
    }
}
