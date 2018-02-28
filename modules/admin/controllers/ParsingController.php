<?php

namespace app\modules\admin\controllers;


use app\models\Material;
use app\modules\admin\Module;
use Html2Text\Html2Text;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use Spatie\PdfToText\Exceptions\PdfNotFound;
use Spatie\PdfToText\Pdf;
use yii\web\Controller;

class ParsingController extends Controller
{
    private static $pathToMaterialAttachments;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public static function parsing($model)
    {
        self::$pathToMaterialAttachments = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'];

        if (!self::checkExistWordFile($model))
            return false;

        if (!self::checkNeedleFile($model))
            return false;

        if (!$wordData = self::getWordData($model))
            return false;

        if (!$htmlData = self::getHtmlData($model))
            return false;

        if (!$pdfData = self::getPdfData($model))
            return false;

        if (!$materialName = self::getMaterialName($wordData, $htmlData))
            return false;

        if (!$parsingMaterialName = self::parsMaterialName($materialName))
            return false;

        if (!$topInfoString = self::getTopInfoString($pdfData, $htmlData, $parsingMaterialName))
            return false;

        $email         = self::getEmails($topInfoString);
        $topInfoString = self::cutEmail($topInfoString, $email);
        $udk           = self::getUdk($topInfoString);
        $nameAuthors   = self::getNameAuthors($topInfoString, $htmlData);
        $topInfoString = self::cutUdk($topInfoString, $udk);
        $topInfoString = self::cutNameAuthors($topInfoString, $nameAuthors);
        $university    = self::getUniversity($topInfoString);
        $tagData       = self::getAnnotationData($htmlData, $pdfData, $parsingMaterialName);

        $parsingData   = self::getParsingData($email, $udk, $nameAuthors, $university, $materialName, $tagData, $model);

        return $parsingData;
    }


    /**
     * @param $model Material
     * @param null $pathToWordFile
     * @return bool
     */
    public static function checkExistWordFile($model, $pathToWordFile = null)
    {
        if (!$pathToWordFile)
            $pathToWordFile = self::$pathToMaterialAttachments.$model->dir.$model->word_file;

        if (file_exists($pathToWordFile)) {

            $infoForFile = self::getInfoForFile($pathToWordFile);

            if ($infoForFile['extension'] != '.docx' && $infoForFile['extension'] != '.doc') {

                \Yii::$app->getSession()->setFlash('error', 'Файл нужного формата не найден (doc/docx)');
                return false;
            }
            return true;
        }
        \Yii::$app->getSession()->setFlash('error', "Такого файла или директории не существует $pathToWordFile");
        return false;
    }

    /**
     * @param $pathToFile
     * @return array
     */
    private static function getInfoForFile($pathToFile)
    {
        $info       = new \SplFileInfo($pathToFile);
        $extension  = '.'.$info->getExtension();
        $basename   = $info->getBasename($extension);

        return ['extension' => $extension, 'basename' => $basename];// add compact
    }

    /**
     * @param $model Material
     * @param null $pathToWordFile
     * @return bool
     */
    public static function checkNeedleFile($model, $pathToWordFile = null)
    {
        if (!$pathToWordFile)
            $pathToWordFile = self::$pathToMaterialAttachments.$model->dir.$model->word_file;

        if (!file_exists($pathToWordFile)) {

            \Yii::$app->getSession()->setFlash('error', "Такого файла или директории не существует $pathToWordFile");
            return false;
        }

        $infoForFile = self::getInfoForFile($pathToWordFile);

        try {
            if (!file_exists(\Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$model->dir.$infoForFile['basename'].'.html'))
                \Yii::$app->converter->convert($pathToWordFile, $infoForFile['basename'], 'html');

            if (!file_exists(\Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$model->dir.$infoForFile['basename'].'.pdf'))
                \Yii::$app->converter->convert($pathToWordFile, $infoForFile['basename'], 'pdf');

            $model->pdf_file   = $infoForFile['basename'].".pdf";
            $model->html_file  = $infoForFile['basename'].".html";
            $model->updated_at = date('Y-m-d');
            $model->save();
        } catch (\Exception $exception) {

            return false;
        }
        return true;
    }

    /**
     * @param $model Material
     * @return array|bool|null
     */
    private static function getWordData($model)
    {
        $pathToWordFile = self::$pathToMaterialAttachments.$model->dir.$model->word_file;

        if (!file_exists($pathToWordFile)) {

            \Yii::$app->getSession()->setFlash('error', "Такого файла или директории не существует $pathToWordFile");
            return false;
        }

        $infoForFile = self::getInfoForFile($pathToWordFile);

        if ($infoForFile['extension'] != '.docx') {
            return true;
        }

        try {
            $objReader = IOFactory::createReader('Word2007');
        } catch (Exception $exception) {
            \Yii::$app->getSession()->setFlash('error', "$exception");
            return false;
        }
        $phpWord = $objReader->load($pathToWordFile);

        $wordText           = '';
        $wordMatherialName  = '';
        $wordBoldString     = '';

        foreach ($phpWord->getSections() as $section)
        {
            $arrays = $section->getElements();

            foreach ($arrays as $e) {
                if(get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {

                    foreach ($e->getElements() as $item) {
                        if (get_class($item) !== 'PhpOffice\PhpWord\Element\Image') {

                            $font = $item->getFontStyle();

                            if($font->getName() == 'Arial' && $font->isBold()) {

                                $wordMatherialName .= $item->getText();
                                $wordText .= $item->getText();
                            }
                            else if($font->isBold() ) {

                                $wordBoldString .= $item->getText().'*';
                                $wordText .= $item->getText();
                            }
                            else {

                                $wordText .= $item->getText();
                            }
                        }
                    }
                }

                else if (get_class($e) === 'PhpOffice\PhpWord\Element\Text') {

                    $font = $e->getFontStyle();

                    if($font->getName() == 'Arial' && $font->isBold()) {

                        $wordMatherialName .= $e->getText();
                        $wordText .= $e->getText();
                    }
                    else if($font->isBold() ) {

                        $wordBoldString .= $e->getText().'*';
                        $wordText .= $e->getText();
                    }
                    else {

                        $wordText .= $e->getText();
                    }
                }
            }
        }

        if ($wordText == '') {
            \Yii::$app->getSession()->setFlash('error', "Файл $pathToWordFile пуст");
            return false;
        }

        return ['text' => $wordText,'materialName' => $wordMatherialName,'boldString' => $wordBoldString];
    }

    /**
     * @param $model Material
     * @return array|bool
     */
    private static function getHtmlData($model)
    {
        $pathToHtmlFile = self::$pathToMaterialAttachments.$model->dir.$model->html_file;

        if (!file_exists($pathToHtmlFile)) {

            \Yii::$app->getSession()->setFlash('error', "Такого файла или директории не существует $pathToHtmlFile");
            return false;
        }

        $infoForFile = self::getInfoForFile($pathToHtmlFile);

        if ($infoForFile['extension'] != '.html') {
            \Yii::$app->getSession()->setFlash('error', "Файл $pathToHtmlFile не является Html файлом");
            return false;
        }

        $dom    = new \DOMDocument;
        $domTop = new \DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTMLFile($pathToHtmlFile);

        $html = file_get_contents($pathToHtmlFile);
        $topHtml = mb_stristr($html, 'Arial', true);
        if (!$topHtml) {
            \Yii::$app->getSession()->setFlash('error', "Заголовок статьи имеет неверный шрифт");
            return false;
        }
        $domTop->loadHTML($topHtml);

        $htmlText = mb_strrchr($dom->textContent, 'УДК');
        $html = new Html2Text($html);
        $htmlTextForTag = $html->getText();

        $xpath = new \DOMXPath($dom);
        $xpathTop = new \DOMXPath($domTop);

        $expressionMaterialName = array(
            '//font[@face="Arial, sans-serif"]',
            '//font[@face="Arial, serif"]',
            '//font[@face="Arial, sans"]',
            '//font[@face="Arial"]',
        );
        $htmlMaterialNameArr = '';
        $htmlMaterialName = '';
        foreach ($expressionMaterialName as $item) {

            $htmlMaterialNameArr = $xpath->query($item);
            if(!$htmlMaterialNameArr->length == 0)
                break;
        }

        foreach ($htmlMaterialNameArr as $item) {

            $htmlMaterialName .= $item->nodeValue;
        }

        $htmlBoldStringArr = $xpathTop->query('//b');
        $htmlBoldString = '';
        foreach ($htmlBoldStringArr as $item) {

            $htmlBoldString .= $item->nodeValue.'*';
        }

        $htmlBoldStringFixArr = $xpathTop->query('//h1');
        foreach ($htmlBoldStringFixArr as $item) {

            $htmlBoldString .= $item->nodeValue.'*';
        }

        if (trim(str_replace('*', '', $htmlBoldString)) == '') {

            \Yii::$app->getSession()->setFlash('info', "Имя автора статьи не выделено жирным");
        }

        if ($htmlText == '') {
            \Yii::$app->getSession()->setFlash('error', "Файл $pathToHtmlFile пуст");
            return false;
        }

        return ['text' => $htmlText, 'textForTag' => $htmlTextForTag, 'materialName' => $htmlMaterialName, 'boldString' => $htmlBoldString];
    }

    /**
     * @param $model Material
     * @return array|bool
     */
    private static function getPdfData($model)
    {
        $pathToPdfFile = self::$pathToMaterialAttachments.$model->dir.$model->pdf_file;

        if (!file_exists($pathToPdfFile)) {

            \Yii::$app->getSession()->setFlash('error', "Такого файла или директории не существует $pathToPdfFile");
            return false;
        }

        $infoForFile = self::getInfoForFile($pathToPdfFile);

        if ($infoForFile['extension'] != '.pdf') {
            \Yii::$app->getSession()->setFlash('error', "Файл $pathToPdfFile не является Pdf файлом");
            return false;
        }
        $parser = new Pdf();
        try {
            $parser->setPdf($pathToPdfFile);
        } catch (PdfNotFound $exception) {
            \Yii::$app->getSession()->setFlash('error', $exception);
            return false;
        }
        $pdfText = $parser->text();

        if ($pdfText == '') {
            \Yii::$app->getSession()->setFlash('error', "Файл $pathToPdfFile пуст");
            return false;
        }

        return array('text' => $pdfText);

    }

    /**
     * @param $wordData
     * @param $htmlData
     * @return bool
     */
    private static function getMaterialName($wordData, $htmlData)
    {
        $materialName = '';

        if ($wordData)
            $materialName = $wordData['materialName'];
        if (strlen($materialName) == 0)
            $materialName = $htmlData['materialName'];

        if (!$materialName) {
            \Yii::$app->getSession()->setFlash('error', "Заголовок статьи имеет неверный шрифт");
            return false;
        }

        return mb_strtoupper($materialName);
    }

    /**
     * @param $materialName
     * @return array|bool
     */
    private static function parsMaterialName($materialName)
    {
        if (!$materialName) {
            \Yii::$app->getSession()->setFlash('error', "Заголовок статьи имеет неверный шрифт");
            return false;
        }

        $firstWordMaterialName = implode(' ',array_slice(preg_split('/\s+/', trim($materialName)),0,1));
        $arr = preg_split('/\s+/', trim($materialName));
        $lastWordMaterialName = (array_pop($arr));

        $countLastWord = substr_count($materialName, $lastWordMaterialName);

        return array('firstWord' => $firstWordMaterialName, 'lastWord' => $lastWordMaterialName, 'countLastWord' => $countLastWord);
    }

    /**
     * @param $pdfData
     * @param $htmlData
     * @param $parsMaterialName
     * @return bool|false|string
     */
    private static function getTopInfoString($pdfData, $htmlData, $parsMaterialName)
    {
        $topInfoString = mb_stristr($htmlData['text'], $parsMaterialName['firstWord'], true);
        if (!$topInfoString)
            $topInfoString = mb_stristr($pdfData['text'], $parsMaterialName['firstWord'], true);

        return $topInfoString;
    }

    /**
     * @param $topInfoString
     * @return string
     */
    private static function getEmails($topInfoString)
    {
        $pattern = '/[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+/i';

        preg_match_all($pattern, str_replace(" ","",$topInfoString), $matches);

        $emails = '';
        foreach ($matches as $match) {

            foreach ($match as $email) {

                $emails .= $email.' ';
            }
        }

        if (!trim($emails)) {

            \Yii::$app->getSession()->setFlash('info', "Отсутствует email автора статьи");
        }
        return $emails;
    }

    /**
     * @param $topInfoString
     * @param $email
     * @return null|string|string[]
     */
    private static function cutEmail($topInfoString, $email)
    {
        if (!$email)
            return $topInfoString;

        $topInfoString = preg_replace('/[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+/i', '', $topInfoString);
        return $topInfoString;
    }

    /**
     * @param $topInfoString
     * @return string
     */
    private static function getUdk($topInfoString)
    {
        $udk = '';

        $arr = explode('УДК', $topInfoString);

        if (count($arr) == 1) {

            \Yii::$app->getSession()->setFlash('info', "Отсутствует Udk");
            return $udk;
        }

        $udk = array_pop($arr);

        $test = explode("\n", $udk);

        $test = array_diff($test, ['']);

        $udkNumber = trim(array_first($test));

        $udk = 'УДК ' . $udkNumber;

        return $udk;
    }

    /**
     * @param $topInfoString
     * @param $udk
     * @return string
     */
    private static function cutUdk($topInfoString, $udk)
    {
        if (!$udk)
            return $topInfoString;

        $arr = explode('УДК', $topInfoString);

        $udk = array_pop($arr);

        $test = explode("\n", $udk);

        $test = array_diff($test, ['']);

        array_shift($test);

        $firstText = implode('', $arr);
        $lasText = implode("\n", $test);

        $topInfoString = trim($firstText.' '.$lasText);

        return $topInfoString;

    }

    /**
     * @param $topInfoString
     * @param $htmlData
     * @return array|string
     */
    private static function getNameAuthors($topInfoString, $htmlData)
    {
        $boldStringArr = explode('*', $htmlData['boldString']);

        $nameAuthor = '';
        foreach ($boldStringArr as $boldItem) {

            $item = $boldItem;

            if ($item != '') {

                $result = mb_strpos($topInfoString, $item);
                if ($result != FALSE) {
                    if ($item == ' ')
                        $nameAuthor .= ' ';
                    $nameAuthor .= $boldItem;
                }
            }
        }

        $nameAuthor = explode('.',$nameAuthor);

        foreach ($nameAuthor as $key => $item) {

            if (empty(trim($item))) {

                unset($nameAuthor[$key]);
            }
        }

        $r = $nameAuthor;

        $nameAuthor = implode('.', $nameAuthor);

        if (iconv_strlen(array_pop($r)) <= 2) {

            $nameAuthor = $nameAuthor.'.';
        }

        //DELETE BOLD UDK...

        return $nameAuthor;
    }

    /**
     * @param $topInfoString
     * @param $nameAuthors
     * @return null|string|string[]
     */
    private static function cutNameAuthors($topInfoString, $nameAuthors)
    {
        if (!$nameAuthors)
            return $topInfoString;

        $topInfoString = preg_replace("/$nameAuthors+/iu", '', $topInfoString);
        return $topInfoString;
    }

    /**
     * @param $topInfoString
     * @return mixed|string
     */
    private static function getUniversity($topInfoString)
    {
        if (mb_stripos($topInfoString, 'E-mail:'))
            $university = str_replace('E-mail:', '', $topInfoString);
        elseif (mb_stripos($topInfoString, 'Е-mail:'))
            $university = str_replace('Е-mail:', '', $topInfoString);
        else
            $university = $topInfoString;

//        die($university);

        $universityArr = explode(',',$university);

        foreach ($universityArr as $key => $item) {

            if (empty(trim($item))) {

                unset($universityArr[$key]);
            }
        }

        $university = implode(',', $universityArr);

        return $university;
    }

    /**
     * @param $htmlData
     * @param $pdfData
     * @param $parsMaterialName
     * @return array|bool
     */
    private static function getAnnotationData($htmlData, $pdfData, $parsMaterialName)
    {
        $verificationData['ua'] =  unserialize(\Yii::$app->config->get('VERIFICATION_WORDS_TO_TAG_UA'));
        $verificationData['us'] =  unserialize(\Yii::$app->config->get('VERIFICATION_WORDS_TO_TAG_US'));
        $verificationData['ru'] =  unserialize(\Yii::$app->config->get('VERIFICATION_WORDS_TO_TAG_RU'));

        $arr = [
            'ru' => ['tags' => '', 'position' => '', 'text' => '', 'word' => ''],
            'ua' => ['tags' => '', 'position' => '', 'text' => '', 'word' => ''],
            'us' => ['tags' => '', 'position' => '', 'text' => '', 'word' => ''],
        ];

        if (!$data = self::getTag($verificationData, $pdfData['text'], $arr))
            return false;

        if (!$data = self::getTag($verificationData, $htmlData['textForTag'], $data))
            return false;

        $positionArr = [
            'ru' => $data['ru']['position'],
            'ua' => $data['ua']['position'],
            'us' => $data['us']['position'],
        ];

        $positionArr = array_diff($positionArr, ['']);

        if (!count($positionArr)) {

            \Yii::$app->getSession()->setFlash('info', "Отсутствуют аннотации");
            return false;
        }
        elseif (count($positionArr) == 1)
            return self::getOneAnnotation($positionArr, $data, $parsMaterialName);
        elseif (count($positionArr) == 2)
            return self::getTwoAnnotation($positionArr, $data, $parsMaterialName);
        elseif (count($positionArr) == 3)
            return self::getThreeAnnotation($positionArr, $data, $parsMaterialName);

        return false;
    }

    /**
     * @param $verificationData
     * @param $textData
     * @param $arr
     * @return bool
     */
    private static function getTag($verificationData, $textData, $arr)
    {
        if (!count($verificationData)) {

            \Yii::$app->getSession()->setFlash('info', "Отсутствуют проверочные слова для аннотаций");
            return false;
        }

        foreach ($verificationData as $country => $words) {

            if($country == 'ru') {

                foreach ($words as $word) {

                    if ($arr['ru']['tags'])
                        break;

                    $arr['ru']['tags']     = mb_stristr(mb_stristr($textData, $word), '.', true);
                    $arr['ru']['position'] = mb_stripos($textData, $word);
                    $arr['ru']['text']     = mb_stristr($textData, $word, true);
                    if ($arr['ru']['tags']) {
                        $arr['ru']['word'] = $word;
                        break;
                    }
                }
            } elseif($country == 'ua') {

                foreach ($words as $word) {

                    if ($arr['ua']['tags'])
                        break;

                    $arr['ua']['tags']     = mb_stristr(mb_stristr($textData, $word), '.', true);
                    $arr['ua']['position'] = mb_stripos($textData, $word);
                    $arr['ua']['text']     = mb_stristr($textData, $word, true);
                    if ($arr['ua']['tags']) {
                        $arr['ua']['word'] = $word;
                        break;
                    }
                }
            } elseif($country == 'us') {

                foreach ($words as $word) {

                    if ($arr['us']['tags'])
                        break;

                    $arr['us']['tags']     = mb_stristr(mb_stristr($textData, $word), '.', true);
                    $arr['us']['position'] = mb_stripos($textData, $word);
                    $arr['us']['text']     = mb_stristr($textData, $word, true);
                    if ($arr['us']['tags']) {
                        $arr['us']['word'] = $word;
                        break;
                    }
                }
            }
        }

        return $arr;
    }

    /**
     * @param $positionArr
     * @param $data
     * @param $parsMaterialName
     * @param null $topWord
     * @return array|bool
     */
    private static function getFirstAnnotation($positionArr, $data, $parsMaterialName, $topWord = null)
    {
        $min = min($positionArr);
        $firstCountry = '';

        foreach ($positionArr as $key => $position) {

            if ($position == $min) {

                $firstCountry = $key;
                unset($positionArr[$key]);
            }
        }

        if (!$firstCountry)
            return false;

        $firstAnnotation     = $data[$firstCountry];
        if ($parsMaterialName['countLastWord'] >= 2) {

            $firstAnnotationText = explode($parsMaterialName['lastWord'], $firstAnnotation['text']);
            $firstAnnotationText = array_slice($firstAnnotationText, $parsMaterialName['countLastWord']);
            $firstAnnotationText = implode($firstAnnotationText);

        } else {
            $firstAnnotationText = mb_stristr($firstAnnotation['text'], trim($parsMaterialName['lastWord']));
            $firstAnnotationText = mb_substr($firstAnnotationText, mb_strlen(trim($parsMaterialName['lastWord'])));
        }

        if ($topWord) {

            $firstAnnotationText = mb_stristr($firstAnnotation['text'], trim($topWord));
            if (mb_strripos($firstAnnotationText, '.')) {
                $firstAnnotationText = mb_stristr($firstAnnotationText, '.');
                $firstAnnotationText = mb_substr($firstAnnotationText, 1);
            }
        }
        $firstAnnotationTag  = trim($firstAnnotation['tags']).'.';

        return ['text' => $firstAnnotationText, 'tag' => $firstAnnotationTag, 'word' => $firstAnnotation['word'], 'position' => $positionArr, 'country' => $firstCountry];
    }

    /**
     * @param $positionArr
     * @param $data
     * @param $parsMaterialName
     * @return array
     */
    private static function getOneAnnotation($positionArr, $data, $parsMaterialName)
    {
        $topAnnotation = self::getFirstAnnotation($positionArr, $data, $parsMaterialName);

        return ['topAnnotation' => $topAnnotation];
    }

    /**
     * @param $positionArr
     * @param $data
     * @param $parsMaterialName
     * @return array
     */
    private static function getTwoAnnotation($positionArr, $data, $parsMaterialName)
    {
        $topAnnotation = self::getFirstAnnotation($positionArr, $data, $parsMaterialName);

        $secondAnnotation = self::getFirstAnnotation($topAnnotation['position'], $data, $parsMaterialName, $topAnnotation['word']);

        return ['topAnnotation' => $topAnnotation, 'secondAnnotation' => $secondAnnotation];
    }

    /**
     * @param $positionArr
     * @param $data
     * @param $parsMaterialName
     * @return array
     */
    private static function getThreeAnnotation($positionArr, $data, $parsMaterialName)
    {
        $topAnnotation = self::getFirstAnnotation($positionArr, $data, $parsMaterialName);

        $secondAnnotation = self::getFirstAnnotation($topAnnotation['position'], $data, $parsMaterialName, $topAnnotation['word']);

        $lastAnnotation = self::getFirstAnnotation($secondAnnotation['position'], $data, $parsMaterialName, $secondAnnotation['word']);

        return ['topAnnotation' => $topAnnotation, 'secondAnnotation' => $secondAnnotation, 'lastAnnotation' => $lastAnnotation];
    }

    /**
     * @param $email
     * @param $udk
     * @param $nameAuthors
     * @param $university
     * @param $materialName
     * @param $tagData
     * @param $model Material
     * @return array
     */
    private static function getParsingData($email, $udk, $nameAuthors, $university, $materialName, $tagData, $model)
    {
        $uaAnnotation = '';
        $usAnnotation = '';
        $ruAnnotation = '';
        $uaTag = '';
        $usTag = '';
        $ruTag = '';

        foreach ($tagData as $value) {

            if ($value['country'] == 'ua') {
                $uaAnnotation = $value['text'];
                $uaTag = $value['tag'];
            }
            if ($value['country'] == 'ru') {
                $ruAnnotation = $value['text'];
                $ruTag = $value['tag'];
            }
            if ($value['country'] == 'us') {
                $usAnnotation = $value['text'];
                $usTag = $value['tag'];
            }
        }
        $parsingData = [
            'udk'           => $udk,
            'author'        => $nameAuthors,
            'university'    => $university,
            'email'         => $email,
            'material_name' => $materialName,
            'ru_annotation' => $ruAnnotation,
            'ua_annotation' => $uaAnnotation,
            'us_annotation' => $usAnnotation,
            'ru_tag'        => $ruTag,
            'ua_tag'        => $uaTag,
            'us_tag'        => $usTag,
            'top_anotation' => $tagData['topAnnotation']['text'],
            'top_tag'       => $tagData['topAnnotation']['tag'],
            'material_html' => ''
        ];

        foreach ($parsingData as $key => $value) {

            $parsingData[$key] = str_replace("\n", " ", $value);
        }

        $parsingData['material_html'] = self::getHtmlForMaterial($email, $udk, $nameAuthors, $university,$materialName, $tagData, $model);

        $parsingData['material_html'] = str_replace("\n", " ", $parsingData['material_html']);

        return $parsingData;
    }


    /**
     * @param $email
     * @param $udk
     * @param $nameAuthors
     * @param $university
     * @param $materialName
     * @param $tagData
     * @param $model Material
     * @return string
     */
    private static function getHtmlForMaterial($email, $udk, $nameAuthors, $university, $materialName, $tagData, $model)
    {
        $materialHtml =
            '<p>' .
            $udk.'<br>'.
            $nameAuthors.'<br>'.
            $university.'<br>'.
            'Е-mail: '.$model->getEmailHtml($email).
            '</p>'.
            '<p>'.
            '<strong>'.$materialName.'</strong>'.
            '<br>'.
            '<br>'.
            $tagData['topAnnotation']['text'].
            '</p>'.
            '<p>'.
            '<br>'.
            $tagData['topAnnotation']['tag'].
            '</p>';

        if (isset($tagData['secondAnnotation']['text']))
            $materialHtml .=
                '<hr>'.
                '<p>'.
                $tagData['secondAnnotation']['text'].
                '</p>'.
                '<p>'.
                '<br>'.
                $tagData['secondAnnotation']['tag'].
                '</p>';

        if (isset($tagData['lastAnnotation']['text']))
            $materialHtml .=
                '<hr>'.
                '<p>'.
                $tagData['lastAnnotation']['text'].
                '</p>'.
                '<p>'.
                '<br>'.
                $tagData['lastAnnotation']['tag'].
                '</p>';

        return $materialHtml;

    }
}