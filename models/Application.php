<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\StaleObjectException;
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

    const STATUS_MODERATION_WAITING_MODERATION = 0;
    const STATUS_MODERATION_ACCEPTED = 1;
    const STATUS_MODERATION_NOT_ACCEPTED = 2;


    /**
     * @return array
     */
    public static function getStatusesModeration()
    {
        return [
            self::STATUS_MODERATION_WAITING_MODERATION => Yii::t('app', 'Waiting Moderation'),
            self::STATUS_MODERATION_ACCEPTED => Yii::t('app', 'Accepted'),
            self::STATUS_MODERATION_NOT_ACCEPTED => Yii::t('app', 'Not accepted'),
        ];
    }

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
                    'conference_id',
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
            ['email', 'validateUniqueEmail'],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => \codemix\yii2confload\Config::env('RECAPTCHA_SECRET_KEY', 'secretKey'), 'uncheckedMessage' => 'Please confirm that you are not a bot.']
        ];
    }

    /**
     * @return bool
     */
    public function validateUniqueEmail()
    {
        $conference = Conference::find()->where(['status' => 1])->one();

        if (!$conference)
            $this->addError('email', 'Активної конференції не існує');

        $application = Application::find()->where(['email' => $this->email])->andWhere(['conference_id' => $conference->id])->count();

        if ($application)
            $this->addError('email', 'З даного емейла можна відіслати тільки одну заявку на дану конференцію.');

        return true;
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
    public function signupConferense()
    {
        if (!$conference = Conference::findOne($this->conference_id))
            return false;

        $participant = Participant::find()->where(['=', 'email', $this->email])->one();
        if (!$participant)
            if (!$participant = $this->createParticipant())
                return false;


        if (!$this->createApplication($participant))
                return false;

        \Yii::$app->session->setFlash('success', 'Заявка успішно відправлена');
        return true;

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
}
