<?php
namespace app\helpers;

use Yii;

class AuthHelper
{
    const RL_ADMIN = 'rl_admin';
    const RL_ADMIN_SYSTEM = 'rl_admin_system';
    const RL_ADMIN_SECURITY = 'rl_admin_security';
    const RL_OPERATOR_ELECTRICITY = 'rl_operator_electricity';
    const RL_OPERATOR_WARM = 'rl_operator_warm';
    const RL_OPERATOR_WATER = 'rl_operator_water';
    const RL_PROVIDER_ELECTRICITY = 'rl_provider_electricity';
    const RL_APPLICANT = 'rl_applicant';

    /**
     * {@inheritdoc}
     */
    public static function getRoles()
    {
        return [
            'rl_admin' => 'Функциональный администратор',
            'rl_admin_system' => 'Системный администратор',
            'rl_admin_security' => 'Администратор безопасности',
            'rl_operator_electricity' => 'Оператор по электросетям',
            'rl_operator_warm' => 'Оператор по тепловым сетям',
            'rl_operator_water' => 'Оператор по водоснабжению и водоотведению',
            'rl_provider_electricity' => 'Гарантирующий поставщик (для ЭС)',
            'rl_applicant' => 'Заявитель',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getRolesTranslate()
    {
        return [
            'Функциональный администратор' => 'rl_admin',
            'Системный администратор' => 'rl_admin_system',
            'Администратор безопасности' => 'rl_admin_security',
            'Оператор по электросетям' => 'rl_operator_electricity',
            'Оператор по тепловым сетям' => 'rl_operator_warm',
            'Оператор по водоснабжению и водоотведению' => 'rl_operator_water',
            'Гарантирующий поставщик (для ЭС)' => 'rl_provider_electricity',
            'Заявитель' => 'rl_applicant',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function getUserRoles($user_id)
    {
        $roles = Yii::$app->authManager->getRolesByUser($user_id);
        $roles = array_keys($roles);
        $roles = array_filter($roles, function ($val){
            return ($val != 'guest');
        });
        $roles = array_values($roles);

        return $roles;
    }

    /**
     * {@inheritdoc}
     */
    public static function getUserRolesTranslate($role, $roles)
    {
        return array_search($role[0], $roles);
    }
}