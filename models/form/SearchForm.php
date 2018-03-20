<?php

namespace app\models\form;


use yii\base\Model;

class SearchForm extends Model
{
    public $q;
    public $type;

    public function rules()
    {
        return [
            ['q', 'filter', 'filter' => 'trim'],
            ['q', 'string', 'min' => 2, 'max' => 255],
            ['type', 'filter', 'filter' => 'trim'],
            ['type', 'string', 'min' => 1, 'max' => 10],
        ];
    }
}