<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "electricity".
 *
 * @property int $id Id
 * @property int|null $connection Планируемая мощность энергопринимающего устройства и тип подключения
 * @property int|null $management Способ документооборота
 * @property int|null $applicant Статус заявителя
 * @property int|null $status Статус заявки
 * @property int|null $created_at Дата и время создания
 * @property int|null $updated_at Дата и время изменения
 * @property string|null $user_last Последний пользователь
 * @property string|null $user_first Пользователь создавший
 */
class ElectricityBase extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'electricity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['connection', 'management', 'applicant', 'status'], 'required'],
            [['connection', 'management', 'applicant', 'status'], 'integer'],
            [['user_last', 'user_first'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'connection' => Yii::t('app', 'Планируемая мощность энергопринимающего устройства и тип подключения'),
            'management' => Yii::t('app', 'Способ документооборота'),
            'applicant' => Yii::t('app', 'Статус заявителя'),
            'status' => Yii::t('app', 'Статус заявки'),
            'created_at' => Yii::t('app', 'Дата и время создания'),
            'updated_at' => Yii::t('app', 'Дата и время изменения'),
            'user_last' => Yii::t('app', 'Последний пользователь'),
            'user_first' => Yii::t('app', 'Пользователь создавший'),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = ArrayHelper::merge($behaviors, [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ]);
        return $behaviors;
    }
}