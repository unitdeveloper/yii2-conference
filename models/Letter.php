<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%letter}}".
 *
 * @property int $id
 * @property string $created_at
 * @property int $participant_id
 * @property int $material_id
 * @property int $status
 * @property string $message
 *
 * @property Material $material
 * @property Participant $participant
 */
class Letter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%letter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'message'], 'safe'],
            [['participant_id', 'material_id', 'status'], 'integer'],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['material_id' => 'id']],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'participant_id' => 'Participant ID',
            'material_id' => 'Material ID',
            'status' => 'Status',
            'message' => 'Message'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!$this->created_at) {

            $this->created_at = date('Y-m-d');
        }

        return parent::beforeSave($insert);
    }
}
