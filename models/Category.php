<?php

namespace app\models;

use app\models\job\RemoveMaterialDirJob;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $name
 * @property integer $conference_id
 *
 * @property Material[] $materials
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'conference_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['conference_id'], 'exist', 'skipOnError' => false, 'targetClass' => Conference::className(), 'targetAttribute' => ['conference_id' => 'id']],
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
            'conference_id' => 'Conference',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Letter::className(), ['id' => 'conference_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CategoryQuery(get_called_class());
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
