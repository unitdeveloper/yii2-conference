<?php

namespace app\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property int $id
 * @property string $param
 * @property string $value
 * @property string $default
 * @property string $label
 * @property string $type
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['param', 'value', 'default', 'label', 'type'], 'required'],
            [['value', 'default'], 'string'],
            [['param', 'label', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param' => 'Param',
            'value' => 'Value',
            'default' => 'Default',
            'label' => 'Label',
            'type' => 'Type',
        ];
    }

    /**
     * Conversion of a config value to a string
     * @return string
     */
    public function getValueToStr()
    {
        if ($this->type == 'array') {

            try {

                $arr = unserialize($this->value);
            } catch (\Exception $exception) {

                return $this->value;
            }

            foreach ($arr as $value) {

                if (is_array($value)) {

                    $value = implode(', ', $value);
                } else {

                    $value = implode(', ', $arr);
                }
            }

            return $value;

        } else {

            return $this->value;
        }
    }

    /**
     * Getting the html line from the config value
     * @return string
     */
    public function getValue()
    {
        if ($this->type == 'array') {

            $arr = unserialize($this->value);
            foreach ($arr as $value) {

                if (is_array($value)) {

                    $value = implode(', ', $value);
                } else {

                    $value = implode('<br>', $arr);
                }
            }

            return '<pre>'.$value.'</pre>';

        } else {

            return $this->value;
        }
    }

    /**
     * Forming a valid value before writing to the database
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->type == 'array') {

            if ($this->param == 'INBOX_DATA') {

                $arr = explode(',', trim($this->value));

                $arr = array_diff($arr, ['']);
                if (count($arr) != 3) {
                    Yii::$app->getSession()->setFlash('error', 'Неправильно вказано значення формату');
                    return false;
                }
                $data['hostname'] = trim($arr[0]);
                $data['username'] = trim($arr[1]);
                $data['password'] = trim($arr[2]);
            } else if ($this->param == 'VERIFICATION_WORDS_TO_TAG_UA' || $this->param == 'VERIFICATION_WORDS_TO_TAG_RU' || $this->param == 'VERIFICATION_WORDS_TO_TAG_US') {

                if (mb_stripos($this->value, ',')) {

                    $arr = explode(',', $this->value);
                    foreach ($arr as $k => $v) {

                        $arr[$k] = trim($v);
                    }
                }
                else {

                    $arr = [trim($this->value)];
                }

                $data = $arr;
            }
//            else if ($this->param == 'MAILER_DATA') {
//
//                $arr = explode(',', $this->value);
//                $data['class'] = trim($arr[0]);
//                $data['host'] = trim($arr[1]);
//                $data['username'] = trim($arr[2]);
//                $data['password'] = trim($arr[3]);
//                $data['port'] = trim($arr[4]);
//                $data['encryption'] = trim($arr[5]);
//            }

            $this->value = serialize($data);
        }

        return parent::beforeSave($insert);
    }

}
