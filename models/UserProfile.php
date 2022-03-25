<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id Id записи
 * @property int|null $user_id Id пользователя
 * @property string $insurance_number Страховой номер индивидуального лицевого счета (СНИЛС)
 * @property string $tax_businessman ИНН индивидуального предпринимателя
 * @property string $registration_number Номер ОГРНИП
 * @property string $tax_legal ИНН юридического лица
 * @property string $main_number Номер ОГРН
 *
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['insurance_number', 'tax_businessman', 'registration_number', 'tax_legal', 'main_number'], 'string', 'max' => 32],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id записи'),
            'user_id' => Yii::t('app', 'Id пользователя'),
            'insurance_number' => Yii::t('app', 'Страховой номер индивидуального лицевого счета (СНИЛС)'),
            'tax_businessman' => Yii::t('app', 'ИНН индивидуального предпринимателя'),
            'registration_number' => Yii::t('app', 'Номер ОГРНИП'),
            'tax_legal' => Yii::t('app', 'ИНН юридического лица'),
            'main_number' => Yii::t('app', 'Номер ОГРН'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}