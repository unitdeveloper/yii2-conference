<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%application}}".
 *
 * @property int $id
 * @property string $created_at
 * @property int $participant_id
 * @property int $user_id
 * @property int $material_id
 * @property string $first_name
 * @property string $last_name
 * @property string $surname
 * @property string $degree
 * @property string $position
 * @property string $work_place
 * @property string $address_speaker
 * @property int $phone
 * @property string $email
 * @property string $title_report
 * @property int $category_id
 * @property int $conference_id
 * @property string $surnames_co_authors
 * @property int $status
 *
 * @property Category $category
 * @property Material $material
 * @property Participant $participant
 */
class Application extends \yii\db\ActiveRecord
{

    public $reCaptcha;
    public $article_file;
    public $application_file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
//                    'conference_id',
                    'phone',
                    'first_name',
                    'last_name',
                    'surname',
                    'degree',
                    'position',
                    'work_place',
                    'address_speaker',
                    'email',
                    'title_report',
                ],
                'required'
            ],

            [['created_at'], 'safe'],
            [['participant_id', 'user_id', 'conference_id', 'material_id', 'phone', 'category_id', 'status'], 'integer'],
            [['first_name', 'last_name', 'surname', 'degree', 'position', 'work_place', 'address_speaker', 'email', 'title_report', 'surnames_co_authors'], 'string', 'min' => 2, 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['material_id' => 'id']],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
            [['conference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conference_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],

            [['first_name', 'last_name', 'surname', 'degree', 'position', 'work_place', 'address_speaker', 'email', 'title_report', 'surnames_co_authors'], 'filter', 'filter' => 'trim'],

            ['email', 'email'],

            [['article_file'], 'file', 'skipOnEmpty' => true, 'extensions' => ['doc','docx']],

            [['application_file'], 'file', 'skipOnEmpty' => true, 'extensions' => ['doc','docx']],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => \codemix\yii2confload\Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'participant_id' => Yii::t('app', 'Participant'),
            'conference_id' => Yii::t('app', 'Conference'),
            'material_id' => Yii::t('app', 'Material'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'surname' => Yii::t('app', 'Surname'),
            'degree' => Yii::t('app', 'Degree'),
            'position' => Yii::t('app', 'Position'),
            'work_place' => Yii::t('app', 'Work Place'),
            'address_speaker' => Yii::t('app', 'Address Speaker'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'title_report' => Yii::t('app', 'Title Report'),
            'category_id' => Yii::t('app', 'Category'),
            'surnames_co_authors' => Yii::t('app', 'Surnames co-authors'),
            'status' => Yii::t('app', 'Status'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conference_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
                'updatedAtAttribute' => false,
                'value' => date('Y-m-d'),
            ]
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->article_file = UploadedFile::getInstance($this, 'article_file');
        $this->application_file = UploadedFile::getInstance($this, 'application_file');

        return parent::beforeValidate();
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function signupConferense()
    {
        $participant = Participant::find()->where(['=', 'email', $this->email])->one();
        if (!$participant)
            if (!$participant = $this->createParticipant())
                return false;


        if (!$this->createApplication($participant))
                return false;

        \Yii::$app->session->setFlash('success', 'Заявка успішно відправлена');
        return true;

//            if ($material = $this->createMaterial($participant)) {
//
//                if (!$this->createAttachments($material))
//                    return false;
//
//                if (!$this->createApplication($participant, $material))
//                    return false;
//
//                \Yii::$app->session->setFlash('success', 'Заявка успішно відправлена');
//                return true;
//            }
//
//            \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
//            return false;

    }

    /**
     * @param $participant Participant
     * @param $material Material
     * @return bool
     */
    public function createApplication($participant, $material = null)
    {
        $this->participant_id = $participant->id;
        $this->user_id = \Yii::$app->user->id;
        if ($material)
            $this->material_id    = $material->id;

        if ($this->save())
            return true;

        \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
        return false;
    }

    /**
     * @param $participant
     * @return Material|bool
     */
    public function createMaterial($participant)
    {
        $material = new Material();
        $material->participant_id = $participant->id;

        if ($material->save()) {
            return $material;
        }

        \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
        return false;
    }

    /**
     * @return Participant|bool
     */
    public function createParticipant()
    {
        $participant = new Participant();
        $participant->name = $this->first_name. ' ' .$this->last_name;
        $participant->email = $this->email;

        if ($participant->save())
            return $participant;

        \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
        return false;
    }

    /**
     * @param $material
     * @return bool
     */
    public function createAttachments($material)
    {
        $dir = \Yii::$app->getBasePath().\Yii::$app->params['PathToAttachments'].$material->dir;

        try {
            if ($article_file = $this->article_file) {

                $article_file->saveAs($dir . $article_file->name);
            }

            if ($application_file = $this->application_file) {

                $application_file->saveAs($dir . $application_file->name);
            }

        } catch (\Exception $exception) {
            \Yii::$app->session->setFlash('error', 'Не вдалося відправити заявку');
            return false;
        }

        return true;
    }
}
