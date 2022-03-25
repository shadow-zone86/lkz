<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\helpers\AuthHelper;

/**
 * This is the model class for registration form.
 *
 * @property int $id ИД записи
 * @property string $insurance_number Страховой номер индивидуального лицевого счета (СНИЛС)
 * @property string $tax_businessman ИНН индивидуального предпринимателя
 * @property string $registration_number Номер ОГРНИП
 * @property string $tax_legal ИНН юридического лица
 * @property string $main_number Номер ОГРН
 * @property string $email Электронная почта
 * @property string $password Пароль
 * @property string $password_repeat Повтор пароля
 * @property string $status Статус
 * @property string $role Роль
 * @property string $username Имя пользователя
 * @property $verifyCode Введите код с картинки (captcha)
 *
 * @property User $user
 */
class RegistrationForm extends Model
{
    const SCENARIO_REGISTER = 'scenario_register';
    const SCENARIO_UPDATE = 'scenario_update';
    const SCENARIO_CHANGE_PASS = 'scenario_change_pass';

    public $id;
    public $insurance_number;
    public $tax_businessman;
    public $registration_number;
    public $tax_legal;
    public $main_number;
    public $email;
    public $password;
    public $password_repeat;
    public $status;
    public $role;
    public $username;
    public $verifyCode;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['insurance_number', 'tax_businessman', 'registration_number', 'tax_legal', 'main_number'], 'string', 'max' => 32],

            [['email'], 'email'],
            ['status', 'in', 'range' => array_keys(User::getStatus())],

            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id' => 'id']],
            [['password_repeat', 'password'], 'string', 'min' => 6],
            [['password_repeat', 'password'], 'required', 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_CHANGE_PASS]],
            ['password_repeat', 'validatePasswordRepeat', 'skipOnEmpty' => false, 'skipOnError' => false, 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_CHANGE_PASS]],

            [['role'], 'string', 'max' => 50],
            [['role'], 'in', 'range' => array_keys(AuthHelper::getRoles())],
            [['role'], 'required', 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_UPDATE]],
            [['role'], 'default', 'value' => null],

            [['username'], 'string', 'max' => 50],
            [['username'], 'required', 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_UPDATE]],
            [['username'], 'validateUniqueUsername', 'on' => [self::SCENARIO_REGISTER, self::SCENARIO_UPDATE]],

            ['verifyCode', 'captcha', 'on' => 'insert'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['insurance_number', 'tax_businessman', 'registration_number', 'tax_legal', 'main_number', 'password_repeat', 'password', 'role', 'username', 'email'];
        $scenarios[self::SCENARIO_UPDATE] = ['insurance_number', 'tax_businessman', 'registration_number', 'tax_legal', 'main_number', 'role', 'username', 'email'];
        $scenarios[self::SCENARIO_CHANGE_PASS] = ['password_repeat', 'password'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ИД-операции'),
            'insurance_number' => Yii::t('app', 'СНИЛС'),
            'tax_businessman' => Yii::t('app', 'ИНН индивидуального предпринимателя'),
            'registration_number' => Yii::t('app', 'Номер ОГРНИП'),
            'tax_legal' => Yii::t('app', 'ИНН юридического лица'),
            'main_number' => Yii::t('app', 'Номер ОГРН'),
            'email' => Yii::t('app', 'Электронная почта'),
            'password' => Yii::t('app', 'Пароль'),
            'password_repeat' => Yii::t('app', 'Повтор пароля'),
            'status' => Yii::t('app', 'Статус'),
            'role' => Yii::t('app', 'Роль'),
            'username' => Yii::t('app', 'Имя пользователя'),
        ];
    }

    /**
     * Проверка на ввод повтора пароля
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validatePasswordRepeat($attribute, $params, $validator)
    {
        if ($this->password != $this->{$attribute}) {
            $this->addError($attribute, Yii::t('app', 'Не верно указан повтор пароля'));
        }
    }

    /**
     * Проверка на уникальность имени пользователя
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validateUniqueUsername($attribute, $params, $validator)
    {
        $user = $this->$attribute;
        if ($this->id) {
            $duplicateUser = User::find()->andWhere(['username' => $user])->andWhere(['<>', 'id', $this->id])->one();
        } else {
            $duplicateUser = User::findOne(['username' => $user]);
        }
        if ($duplicateUser) {
            $this->addError($attribute, Yii::t('app', 'Имя пользователя уже задействовано для другого пользователя'));
        }
    }

    /**
     * Регистрация нового пользователя
     * @throws \Throwable
     */
    public function register()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // создаем пользователя
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = User::STATUS_ACTIVE;
            $user->status = $this->status;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->generateAuthKey();

            if ($user->save()) {
                $user->refresh();
            } else {
                $this->addErrors($user->errors);
                $transaction->rollBack();
                return false;
            }
            $this->id = $user->id;

            // добавляем роль
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->role);
            $auth->assign($role, $user->id);

            // создаем профиль
            $userProfile = new UserProfile([
                'user_id' => $user->id,
                'insurance_number' => $this->insurance_number,
                'tax_businessman' => $this->tax_businessman,
                'registration_number' => $this->registration_number,
                'tax_legal' => $this->tax_legal,
                'main_number' => $this->main_number,
            ]);

            if (!$userProfile->save()) {
                $this->addErrors($user->errors);
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Модификация пользователя
     * @throws \Throwable
     */
    public function updateProfile()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // модификация профиля пользователя
            $user = User::findOne(['id' => $this->id]);
            $user->username = $this->username;
            $user->email = $this->email;
            if (!$user->save(false)) {
                $this->addError('username', 'Ошибка в имени пользователя');
                $transaction->rollBack();
                return false;
            }

            $userProfile = UserProfile::findOne(['user_id' => $this->id]);
            $userProfile->insurance_number = $this->insurance_number;
            $userProfile->tax_businessman = $this->tax_businessman;
            $userProfile->registration_number = $this->registration_number;
            $userProfile->tax_legal = $this->tax_legal;
            $userProfile->main_number = $this->main_number;

            if (!$userProfile->save(true)) {
                $this->errors = $userProfile->errors;
                $transaction->rollBack();
                return false;
            }

            // обновление роли пользователя
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->role);
            // удаляем текущие роли
            $auth->revokeAll($this->id);
            // присваиваем новую роль
            $auth->assign($role, $this->id);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Поиск пользователя по id
     * @param $user_id
     */
    public static function findByUserId($user_id)
    {
        $user = User::findOne(['id' => $user_id]);
        if (!$user) return null;
        $profile = $user->userProfile;

        $registeredUser = new RegistrationForm([
            'id' => $user->id,
            'insurance_number' => $profile->insurance_number,
            'tax_businessman' => $profile->tax_businessman,
            'registration_number' => $profile->registration_number,
            'tax_legal' => $profile->tax_legal,
            'main_number' => $profile->main_number,
            'email' => $user->email,
            'status' => $user->status,
            'role' => self::getRegisteredUserRole($user->id),
            'username' => $user->username,
        ]);

        return $registeredUser;
    }

    /**
     * Определение роли пользователя по id
     * @param $user_id
     */
    public static function getRegisteredUserRole($user_id)
    {
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($user_id);
        $roles = array_keys($roles);
        $roles = array_diff($roles, ['guest']);
        $role = (count($roles) ? array_shift($roles) : null);
        return $role;
    }

    /**
     * Активация пользователя
     */
    public function activateUser()
    {
        $user = User::findOne($this->id);
        $user->status = User::STATUS_ACTIVE;
        return $user->save(false);
    }

    /**
     * Деактивация пользователя
     */
    public function deactivateUser()
    {
        $user = User::findOne($this->id);
        $user->status = User::STATUS_DELETED;
        return $user->save(false);
    }

    /**
     * Полное удаление пользователя
     * @throws \Throwable
     */
    public function deleteRegisteredUser()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            UserProfile::deleteAll(['user_id' => $this->id]);
            User::findOne(['id' => $this->id])->delete();
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}