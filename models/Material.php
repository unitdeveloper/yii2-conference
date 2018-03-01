<?php

namespace app\models;

use Yii;
use yii\base\Exception;
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
 * @property string $top_tag
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
            [['material_html', 'top_tag', 'top_anotation', 'ru_annotation', 'ua_annotation', 'us_annotation', 'ru_tag', 'ua_tag', 'us_tag',], 'string'],
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
    public function getTopTagHtml()
    {
        $tagStr = trim(mb_substr(mb_stristr($this->top_tag, ':'), 1));

        $tagArr = explode(',', $tagStr);

        $html = '';

        foreach ($tagArr as $tag) {

            $html .=
                "<li>
                    <a href=".Url::to(['/matherial/search', 'parameters' => $tag]).">$tag</a>
                </li>"
            ;
        }

        return $html;

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
        foreach ($files as $file) {

            $result .= "<a href=".Url::to(['/admin/material/download', 'resource' => $file]).">".str_replace(\Yii::$app->getBasePath() . \Yii::$app->params['PathToAttachments']. $this->dir,'',$file)."</a>".'<br>';
        }

        return $result;
    }

    /**
     * Loading a word document into a working directory material
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {

        if (!$this->publisher_at && $this->status_publisher != 0) {

            $this->publisher_at = date('Y-m-d');
        }

        if (!$this->created_at) {

            $this->created_at = date('Y-m-d');

            if (empty($this->dir)) {

                try {
                    $this->dir = '/'.strtotime('now').'_'.\Yii::$app->getSecurity()->generateRandomString(4).'/';
                } catch (Exception $exception) {
                    return $exception;
                }

                $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir;
                if (!file_exists($dir)) {
                    try {
                        FileHelper::createDirectory($dir);
                    } catch (\Exception $exception) {
                        return $exception;
                    }
                }
            }

        } else {

            $this->updated_at = date('Y-m-d');
        }

        if ($wordFile = UploadedFile::getInstance($this, 'wordFile')) {

            $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir;

            $this->removeBasicFile();

            $this->word_file = $wordFile->name;

            $this->removeFile($dir.$this->word_file);
            $this->removeFile($dir.$wordFile->baseName.'.pdf');
            $this->removeFile($dir.$wordFile->baseName.'.html');

            $wordFile->saveAs($dir.$this->word_file);
        }

        if (file_exists(\Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.trim($this->word_file))) {

            $this->word_file = trim($this->word_file);
        } else {

            $this->word_file = '';
        }

        if (file_exists(\Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.$this->pdf_file)) {

            $this->pdf_file = trim($this->pdf_file);
        } else {

            $this->pdf_file = '';
        }

        if (file_exists(\Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.$this->html_file)) {

            $this->html_file = trim($this->html_file);
        } else {

            $this->html_file = '';
        }



        return parent::beforeSave($insert);
    }

    /**
     * Deleting work directory materials
     * @return bool
     */
    public function beforeDelete()
    {
        $dir = mb_strrchr($this->dir, '/', true);

        if ($dir != '') {

            $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir;

            if (file_exists($dir)) {

                self::removeDirectory($dir);
            }
        } else {

            $this->removeBasicFile();

        }

        return parent::beforeDelete();
    }

    /**
     * Deleting basic file (doc/docx, pdf, html) materials
     * @return bool
     */
    public function removeBasicFile()
    {

        if (!empty($this->word_file)) {

            $word = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.$this->word_file;

            if (file_exists($word)) {
                $this->removeFile($word);
            }
        }
        if (!empty($this->pdf_file)) {

            $pdf = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.$this->pdf_file;

            if (file_exists($pdf)) {
                $this->removeFile($pdf);
            }
        }

        if (!empty($this->html_file)) {

            $html = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$this->dir.$this->html_file;

            if (file_exists($html)) {
                $this->removeFile($html);
            }
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

        if ($objs = glob($dir."/*")) {

            foreach($objs as $obj) {

                is_dir($obj) ? self::removeDirectory($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }

    /**
     * Composing a request for material search
     * @param $query
     * @return object
     */
    public static function search($query)
    {
        $response = Material::find()
            ->where(['like', 'udk', $query])
            ->orWhere(['like', 'author', $query])
            ->orWhere(['like', 'university', $query])
            ->orWhere(['like', 'email', $query])
            ->orWhere(['like', 'material_name', $query])
            ->orWhere(['like', 'ru_annotation', $query])
            ->orWhere(['like', 'ua_annotation', $query])
            ->orWhere(['like', 'us_annotation', $query])
            ->orWhere(['like', 'ru_tag', $query])
            ->orWhere(['like', 'ua_tag', $query])
            ->orWhere(['like', 'us_tag', $query]);

        return $response;
    }
}
