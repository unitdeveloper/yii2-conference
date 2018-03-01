<?php

namespace app\models\form;


use yii\base\Model;

class SearchForm extends Model
{
    public $q;

    public function rules()
    {
        return [
            ['q', 'string', 'min' => 2, 'max' => 255],
        ];
    }
}