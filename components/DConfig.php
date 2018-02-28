<?php

namespace app\components;

use app\models\Config;
use yii\base\Component;
use yii\db\Exception;
use yii\helpers\Html;

class DConfig extends Component
{
    protected $data = array();

    public function init()
    {
        $items = Config::find()->all();

        foreach ($items as $item){
            if ($item->param)
                $this->data[$item->param] = $item->value === '' ?  $item->default : $item->value;
        }
        parent::init();
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->data)){
            return $this->data[$key];
        } else {
            throw new Exception('Undefined parameter '.$key);
        }
    }

    public function set($key, $value)
    {
        $model = Config::findOne(['param'=>$key]);
        if (!$model)
            throw new Exception('Undefined parameter '.$key);

        $this->data[$key] = $value;
        $model->value = $value;
        $model->save();
    }

}