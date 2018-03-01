<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%participant}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 */
class Participant extends \yii\db\ActiveRecord
{
    public $material;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%participant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 255],
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
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['participant_id' => 'id']);
    }

    /**
     * Deleting work directory related materials
     * @return bool
     */
    public function beforeDelete()
    {
        $materials = $this->materials;

        foreach ($materials as $material) {

            $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir;

            Material::removeDirectory($dir);
        }
        return parent::beforeDelete();
    }

}
