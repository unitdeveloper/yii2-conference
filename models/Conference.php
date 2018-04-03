<?php

namespace app\models;

use app\models\job\RemoveMaterialDirJob;
use Yii;

/**
 * This is the model class for table "{{%conference}}".
 *
 * @property int $id
 * @property string $name
 * @property integer $status
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
            [['status'], 'integer'],
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

    /**
     * Deleting work directory related materials
     * @return bool
     */
    public function beforeDelete()
    {
        $materials = $this->materials;

        if(!\Yii::$app->queue->push(new RemoveMaterialDirJob([
            'materials' => $materials,
        ]))) {
            \Yii::$app->getSession()->setFlash('error', "Не вдалося видалити робочі директорії матеріалів");
        }

        return parent::beforeDelete();
    }
}
