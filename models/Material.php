<?php

namespace app\models;

use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%material}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $conference_id
 * @property int $participant_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $publisher_at
 * @property string $udk
 * @property string $author
 * @property string $university
 * @property string $email
 * @property string $additional_information
 * @property string $material_name
 * @property string $ru_annotation
 * @property string $ua_annotation
 * @property string $us_annotation
 * @property string $ru_tag
 * @property string $ua_tag
 * @property string $us_tag
 * @property string $top_anotation
 * @property string $second_annotation
 * @property string $last_annotation
 * @property string $top_tag
 * @property string $second_tag
 * @property string $last_tag
 * @property string $material_html
 * @property int $status_publisher
 * @property string $dir
 * @property string $word_file
 * @property string $pdf_file
 * @property string $html_file
 *
 * @property Category $category
 */
class Material extends \yii\db\ActiveRecord
{
    public $wordFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%material}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_publisher', 'participant_id', 'category_id', 'conference_id'], 'integer'],
            [['created_at', 'updated_at', 'publisher_at'], 'date', 'format' => 'php:Y-m-d'],
            [['dir', 'udk', 'author', 'university', 'email', 'material_name', 'word_file', 'pdf_file', 'html_file'], 'string', 'max' => 255],
            [['material_html', 'second_tag', 'last_tag', 'top_tag', 'top_anotation', 'second_annotation', 'last_annotation', 'ru_annotation', 'ua_annotation', 'us_annotation', 'ru_tag', 'ua_tag', 'us_tag',], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['conference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conference_id' => 'id']],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
            [['wordFile'], 'file', 'extensions' => ['doc', 'docx']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'conference_id' => 'Conference',
            'participant_id' => 'Participant',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'publisher_at' => 'Publisher at',
            'udk' => 'Udk',
            'author' => 'Author',
            'university' => 'University',
            'email' => 'Email',
            'material_name' => 'Material name',
            'ru_annotation' => 'Ru annotation',
            'ua_annotation' => 'Ua annotation',
            'us_annotation' => 'Us annotation',
            'ru_tag' => 'Ru tag',
            'ua_tag' => 'Ua tag',
            'us_tag' => 'Us tag',
            'top_anotation' => 'Top annotation',
            'top_tag' => 'Top tag',
            'material_html' => 'Material html',
            'status_publisher' => 'Status publisher',
            'dir' => 'Directory',
            'word_file' => 'Word file',
            'pdf_file' => 'Pdf file',
            'html_file' => 'Html file',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLetter()
    {
        return $this->hasOne(Letter::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conference_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }


    /**
     * @inheritdoc
     * @return \app\models\query\MaterialQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\MaterialQuery(get_called_class());
    }

    /**
     * Forming html string for emails
     * @param null $email
     * @return string
     */
    public function getEmailHtml($email = null)
    {
        if (!$email)
            $email = $this->email;

        $pattern = '/[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+/i';
        preg_match_all($pattern, $email, $matches);
        $emails = '';

        foreach ($matches as $match) {

            foreach ($match as $email) {

                $emails .= "<a href=\"mailto:$email\">$email</a>, ";
            }
        }

        $emails = trim(mb_strrchr($emails, ',', true));
        return "<span>$emails</span><br>";
    }

    /**
     * Forming html string for top tag material
     * @return string
     */
    public function getTopTag()
    {
        $tagStr = trim(mb_substr(mb_stristr($this->top_tag, ':'), 1));

        $tagArr = explode(',', $tagStr);

        return $tagArr;

    }

    /**
     * Getting information about the file size
     * @return string
     */
    public function getFileSize()
    {
        $file = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.$this->pdf_file;

        if(!file_exists($file))
            return "Файл  не найден";

        $filesize = filesize($file);

        if($filesize > 1024){

            $filesize = ($filesize/1024);
            if($filesize > 1024){

                $filesize = ($filesize/1024);
                if($filesize > 1024) {

                    $filesize = ($filesize/1024);
                    $filesize = round($filesize, 1);
                    return $filesize." ГБ";
                } else {

                    $filesize = round($filesize, 1);
                    return $filesize." MБ";
                }
            } else {

                $filesize = round($filesize, 1);
                return $filesize." Кб";
            }
        } else {

            $filesize = round($filesize, 1);
            return $filesize." байт";
        }
    }

    /**
     * Getting information about the structure of the material directory
     * @return bool|string
     */
    public function getDirStructure()
    {
        $dir = mb_strrchr($this->dir, '/', true);

        if ($dir != '') {

            $dir = \Yii::$app->getBasePath() . \Yii::$app->params['PathToAttachments'] . $dir . '/';
        }
        try {
            $files = \yii\helpers\FileHelper::findFiles($dir, ['recursive'=>TRUE]);
        } catch (\Exception $e) {
            return false;
        }

        $result = '';
        foreach ($files as $key => $file) {

            $result .= "<a href=".Url::to(['/admin/material/download', 'resource' => $file]).">".str_replace(\Yii::$app->getBasePath() . \Yii::$app->params['PathToAttachments']. $this->dir,'',$file)."</a>".'<br>';
//            $files[$key] = str_replace(\Yii::$app->getBasePath() . \Yii::$app->params['PathToAttachments']. $this->dir,'',$file);
        }

//        $tree = [];
//
//        $files = [
//            0 => '2018-04-07 09:29:45/1483_1_Мацегора_Ю_С.doc',
//
//            1 => '2018-04-07 09:31:16/1477_4_Сакно_О_Лукічов_О/1477_4_Сакно_О_Лукічов_О.doc',
//            2 => '2018-04-07 09:31:16/1477_5_Люсік_ВО.doc',
//            3 => '2018-04-07 09:31:16/1477_5_Lyshuk_V.doc',
//
//            4 => '2018-04-07 09:31:16/test1/12',
//            5 => '2018-04-07 09:31:16/test1/13',
//
//            6 => '2018-04-07 09:31:17/',
//
//            7 => '1477_5_Lyshuk_V.doc',
//        ];
//
//        echo '<pre>';
//        print_r($files);
//        echo '</pre>';
//
//        foreach ($files as $key => $file) {
//            if (strpos(trim($file, '/'), '/')) {
//                $file = stristr(trim($file, '/'),'/', true);
//                if (!in_array($file, $tree))
//                    $tree[] = $file;
//            }
//            else
//                $tree[] = trim($file, '/');
//        }
//
//
//        echo '<pre>';
//        print_r($tree);
//        echo '</pre>';
//        die();

        return $result;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date('Y-m-d'),
            ]
        ];
    }

    /**
     * @return bool
     */
    public function createWorkDirectory()
    {
        try {
            $this->dir = '/'.strtotime('now').'_'.\Yii::$app->getSecurity()->generateRandomString(4).'/';
        } catch (Exception $exception) {
            \Yii::$app->getSession()->setFlash('error', "Не удалось создать директорию");
            return false;
        }

        $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir;
        if (!file_exists($dir)) {
            try {
                FileHelper::createDirectory($dir);
            } catch (\Exception $exception) {
                \Yii::$app->getSession()->setFlash('error', "Не удалось создать директорию");
                return false;
            }
        }
        return true;
    }

    /**
     * Loading a word document into a working directory material
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {

        if (!$this->publisher_at && $this->status_publisher)
            $this->publisher_at = date('Y-m-d');

        if (!$this->created_at && !$this->dir)
            if (!$this->createWorkDirectory())
                return false;

        if ($wordFile = UploadedFile::getInstance($this, 'wordFile')) {

            $this->removeBasicFile();
            $this->word_file = $wordFile->name;

            $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir;
            $wordFile->saveAs($dir.$this->word_file);
        }

        $files = ['word_file', 'pdf_file', 'html_file',];
        $this->checkExistFiles($files);

        return parent::beforeSave($insert);
    }

    /**
     * @param $files
     */
    public function checkExistFiles($files) {

        foreach ($files as $file) {
            $this->$file = trim($this->$file);
            if (!file_exists(\Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.trim($this->$file)))
                $this->$file = '';
        }
    }

    /**
     * Deleting work directory materials
     * @return bool
     */
    public function beforeDelete()
    {
        if ($this->dir) {

            $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir;
            if (is_dir($dir))
                self::removeDirectory($dir);

        }

        return parent::beforeDelete();
    }

    /**
     * Deleting basic file (doc/docx, pdf, html) materials
     * @return bool
     */
    public function removeBasicFile()
    {
        $path = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir;

        if ($this->word_file) {

            $word = $path.$this->word_file;
            $this->removeFile($word);
        }
        if ($this->pdf_file) {

            $pdf = $path.$this->pdf_file;
            $this->removeFile($pdf);
        }

        if ($this->html_file) {

            $html = $path.$this->html_file;
            $this->removeFile($html);
        }

        return true;
    }

    /**
     * @param $pathToFile
     */
    public function removeFile($pathToFile)
    {
        if (file_exists($pathToFile)) {

            unlink($pathToFile);
        }
    }

    /**
     * Delete specified directory
     * @param $dir
     */
    public static function removeDirectory($dir) {

        if ($objects = glob($dir."/*")) {

            foreach($objects as $obj) {

                is_dir($obj) ? self::removeDirectory($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }

    /**
     * @return array
     */
    public static function getRandomTags()
    {
        $materials = self::find()->active()->orderBy('RAND()')->limit(10)->all();
        $tags = '';
        foreach ($materials as $material) {

            if ($material->top_tag) {

                $tagStr = trim(mb_substr(mb_stristr($material->top_tag, ':'), 1));

                $tagArr = explode(',', $tagStr);

                $position = rand(0, count($tagArr)-1);

                $word = trim($tagArr[$position]);

                if (mb_strlen($word) < 25)
                    $tags .= $word.',';
            }
        }
        $arr = explode(',', $tags);
        $arr = array_diff($arr, ['']);

        foreach ($arr as $key => $value) {

            $arr[$key] = str_replace("\n", "", $value);
        }

        return $arr;
    }

}
