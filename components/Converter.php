<?php

namespace app\components;

use NcJoes\OfficeConverter\OfficeConverter;
use NcJoes\OfficeConverter\OfficeConverterException;
use yii\base\Component;

class Converter extends Component
{
    protected $data = array();

    public function init()
    {

        parent::init();
    }

    /**
     * @param $pathToFile
     * @param $fileBasename
     * @param $needleExtension
     * @return bool
     */
    public function convert($pathToFile, $fileBasename, $needleExtension)
    {
       if (!file_exists($pathToFile)) {

           \Yii::$app->getSession()->setFlash('error', "Такого файла или директории не существует $pathToFile");
           return false;
       }

       $converter = new OfficeConverter($pathToFile);
       try {

           $converter->convertTo("$fileBasename.$needleExtension");
       } catch (OfficeConverterException $exception) {

           \Yii::$app->getSession()->setFlash('error', 'Ошибка создания файлов, возможно програма Libreoffice включена');
           return false;
       }

       return true;

    }

}