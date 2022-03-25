<?php

namespace app\models;

use app\models\base\ElectricityBase;
use Yii;

class Electricity extends ElectricityBase
{
    private $_connection = [
        0 => 'Временное подключение',
        1 => 'Постоянное подключение с планируемой мощностью 0 - 15 кВт',
        2 => 'Постоянное подключение с планируемой мощностью 15 - 150 кВт',
        3 => 'Постоянное подключение с планируемой мощностью 150 - 670 кВт',
        4 => 'Постоянное подключение с планируемой мощностью 670 кВт и выше',
        5 => 'Заключено соглашение о перераспределении мощности',
    ];

    private $_management = [
        0 => 'Документооборот на бумажном носителе',
        1 => 'Электронный документооборот',
    ];

    private $_applicant = [
        0 => 'Физическое лицо',
        1 => 'Индивидуальный предприниматель',
        2 => 'Юридическое лицо',
    ];

    private $_status = [
        100 => 'Регистрация',
        201 => 'Направление технических условий: Составление',
        202 => 'Направление технических условий: Согласование',
        203 => 'Направление технических условий: Подписание',
        204 => 'Направление технических условий: Регистрация',
        205 => 'Направление технических условий: Направление',
        301 => 'Направление договора: Составление',
        302 => 'Направление договора: Согласование',
        303 => 'Направление договора: Подписание',
        304 => 'Направление договора: Направление',
        400 => 'Регистрация договора',
        500 => 'Выполнение технических условий ФГУП ГХК',
        600 => 'Выполнение технических условий Заявителем',
        700 => 'Фактическое присоединение',
        801 => 'Оформление документов: Составление',
        802 => 'Оформление документов: Согласование',
        803 => 'Оформление документов: Подписание актов',
        804 => 'Оформление документов: Направление',
    ];

    /**
     * @inheritdoc
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * @inheritdoc
     */
    public function getManagement()
    {
        return $this->_management;
    }

    /**
     * @inheritdoc
     */
    public function getApplicant()
    {
        return $this->_applicant;
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Добавление новой заявки
     * @throws \Throwable
     */
    public function register()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new Electricity();
            $model->connection = $this->connection;
            $model->management = $this->management;
            $model->applicant = $this->applicant;
            $model->status = $this->status;
            $model->user_first = $this->user_first;
            $model->user_last = $this->user_last;
            if ($model->save()) {
                $model->refresh();
            } else {
                $this->addErrors($model->errors);
                $transaction->rollBack();
                return false;
            }
            $this->id = $model->id;
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
     * @inheritdoc
     */
    public function getElectricity()
    {
        if (Yii::$app->user->can('rl_operator_electricity')) {
            return Electricity::find()->all();
        } else {
            return Electricity::find()->where(['user_first' => Yii::$app->user->identity->username])->all();
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function connectionName($connection)
    {
        $name = null;
        switch ($connection) {
            case 0:
                $name = 'Временное подключение';
                break;
            case 1:
                $name = 'Постоянное подключение с планируемой мощностью 0 - 15 кВт';
                break;
            case 2:
                $name = 'Постоянное подключение с планируемой мощностью 15 - 150 кВт';
                break;
            case 3:
                $name = 'Постоянное подключение с планируемой мощностью 150 - 670 кВт';
                break;
            case 4:
                $name = 'Постоянное подключение с планируемой мощностью 670 кВт и выше';
                break;
            case 5:
                $name = 'Заключено соглашение о перераспределении мощности';
                break;
            default:
                $name = '(Нет данных)';
                break;
        }
        return $name;
    }

    /**
     * {@inheritdoc}
     */
    public static function managementName($management)
    {
        $name = null;
        switch ($management) {
            case 0:
                $name = 'Документооборот на бумажном носителе';
                break;
            case 1:
                $name = 'Электронный документооборот';
                break;
            default:
                $name = '(Нет данных)';
                break;
        }
        return $name;
    }

    /**
     * {@inheritdoc}
     */
    public static function applicantName($applicant)
    {
        $name = null;
        switch ($applicant) {
            case 0:
                $name = 'Физическое лицо';
                break;
            case 1:
                $name = 'Индивидуальный предприниматель';
                break;
            case 2:
                $name = 'Юридическое лицо';
                break;
            default:
                $name = '(Нет данных)';
                break;
        }
        return $name;
    }

    /**
     * {@inheritdoc}
     */
    public static function statusName($status)
    {
        $name = null;
        switch ($status) {
            case 100:
                $name = 'Регистрация';
                break;
            case 201:
                $name = 'Направление технических условий: Составление';
                break;
            case 202:
                $name = 'Направление технических условий: Согласование';
                break;
            case 203:
                $name = 'Направление технических условий: Подписание';
                break;
            case 204:
                $name = 'Направление технических условий: Регистрация';
                break;
            case 205:
                $name = 'Направление технических условий: Направление';
                break;
            case 301:
                $name = 'Направление договора: Составление';
                break;
            case 302:
                $name = 'Направление договора: Согласование';
                break;
            case 303:
                $name = 'Направление договора: Подписание';
                break;
            case 304:
                $name = 'Направление договора: Направление';
                break;
            case 400:
                $name = 'Регистрация договора';
                break;
            case 500:
                $name = 'Выполнение технических условий ФГУП ГХК';
                break;
            case 600:
                $name = 'Выполнение технических условий Заявителем';
                break;
            case 700:
                $name = 'Фактическое присоединение';
                break;
            case 801:
                $name = 'Оформление документов: Составление';
                break;
            case 802:
                $name = 'Оформление документов: Согласование';
                break;
            case 803:
                $name = 'Оформление документов: Подписание актов';
                break;
            case 804:
                $name = 'Оформление документов: Направление';
                break;
            default:
                $name = '(Нет данных)';
                break;
        }
        return $name;
    }
}