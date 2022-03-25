<?php

namespace app\models\search;

use yii\base\Model;
use app\models\ActiveDataProviderOffice;
use Yii;
use yii\db\Query;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class RegistrationFormSearch extends Model
{
    public $id = null;
    public $user_profile_id = null;
    public $insurance_number = null;
    public $tax_businessman = null;
    public $registration_number = null;
    public $tax_legal = null;
    public $main_number = null;
    public $email = null;
    public $status = null;
    public $username = null;
    public $role = null;

    public function rules()
    {
        return [
            [['id', 'user_profile_id', 'insurance_number', 'tax_businessman', 'registration_number', 'tax_legal', 'main_number', 'email', 'status', 'username', 'role'], 'safe'],
        ];
    }

    public function search($params)
    {
        $session = Yii::$app->session;

        if (!isset($params['RegistrationFormSearch'])) {
            if ($session->has('RegistrationFormSearch')){
                $params['RegistrationFormSearch'] = $session['RegistrationFormSearch'];
            }
        } else {
            $session->set('RegistrationFormSearch', $params['RegistrationFormSearch']);
        }

        if (!isset($params['sort'])) {
            if ($session->has('RegistrationFormSearchSort')){
                $params['sort'] = $session['RegistrationFormSearchSort'];
            }
        } else {
            $session->set('RegistrationFormSearchSort', $params['sort']);
        }

        if (isset($params['sort'])) {
            $pos = stripos($params['sort'], '-');
            if ($pos !== false) {
                $typeSort = SORT_DESC;
                $fieldSort = substr($params['sort'], 1);
            } else {
                $typeSort = SORT_ASC;
                $fieldSort = $params['sort'];
            }
        } else {
            $typeSort = SORT_ASC;
            $fieldSort = 'username';
        }

        $query = new Query();
        $query->addSelect([
            'user.id',
            'user_profile.id as user_profile_id',
            'user_profile.user_id as user_id',
            'user_profile.insurance_number as insurance_number',
            'user_profile.tax_businessman as tax_businessman',
            'user_profile.registration_number as registration_number',
            'user_profile.main_number as main_number',
            'user.email',
            'user.status',
            'user.username',
//            new Expression("
//            (
//                select string_agg(auth_assignment.item_name, ',' order by auth_assignment.item_name)
//                from auth_assignment
//                left join auth_item on (auth_item.name = auth_assignment.item_name)
//                where auth_assignment.user_id = \"user\".id::varchar
//                      and auth_item.type = 1
//            ) as role"),
        ])->from('user')
//            ->leftJoin('user_profile', 'user_profile.user_id = "user".id');
            ->leftJoin('`user_profile`', '`user_profile`.`user_id` = `user`.`id`');

        $dataProvider = new ActiveDataProviderOffice([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    $fieldSort => $typeSort,
                ],
            ],
        ]);

        $dataProvider->key = 'id';

        $dataProvider->setSort([
            'defaultOrder' => [
                $fieldSort => $typeSort,
            ],
            'attributes' => [
                'insurance_number',
                'tax_businessman',
                'registration_number',
                'tax_legal',
                'main_number',
                'email',
                'status',
                'username',
                'role',
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['=', 'user.username', $this->username]);
        $query->andFilterWhere(['=', 'user_profile.insurance_number', $this->insurance_number]);
        $query->andFilterWhere(['ilike', 'user_profile.tax_businessman', $this->tax_businessman]);
        $query->andFilterWhere(['ilike', 'user_profile.registration_number', $this->registration_number]);
        $query->andFilterWhere(['ilike', 'user_profile.registration_number', $this->tax_legal]);
        $query->andFilterWhere(['ilike', 'user_profile.registration_number', $this->main_number]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels = ArrayHelper::merge($labels, [
            'insurance_number' => Yii::t('app', 'Номер СНИЛС'),
            'tax_businessman' => Yii::t('app', 'ИНН индивидуального предпринимателя'),
            'registration_number' => Yii::t('app', 'Номер ОГРНИП'),
            'tax_legal' => Yii::t('app', 'ИНН юридического лица'),
            'main_number' => Yii::t('app', 'Номер ОГРН'),
            'email' => Yii::t('app', 'Электронная почта'),
            'status' => Yii::t('app', 'Статус'),
            'username' => Yii::t('app', 'Имя пользователя'),
            'role' => Yii::t('app', 'Роль'),
        ]);
        return $labels;
    }
}