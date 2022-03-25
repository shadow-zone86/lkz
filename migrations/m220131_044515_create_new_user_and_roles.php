<?php

use yii\db\Migration;

/**
 * Class m220131_044515_create_new_user_and_roles
 */
class m220131_044515_create_new_user_and_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user['username'] = 'vc0042';
        $user['email'] = 'RISokolovskiy@mcc.krasnoyarsk.su';
        $user['password_hash'] = \Yii::$app->security->generatePasswordHash('Se2ti#GhK*');
        $user['auth_key'] = \Yii::$app->security->generateRandomString();
        $user['created_at'] = $user['updated_at'] = time();
        $this->insert('user', $user);

        $user_id = $this->db->getLastInsertID();

        $this->createTable('user_profile', [
            'id' => $this->primaryKey()->comment('Id записи'),
            'user_id' => $this->integer()->comment('Id пользователя'),
            'insurance_number' => $this->string(32)->notNull()->comment('Страховой номер индивидуального лицевого счета (СНИЛС)'),
            'tax_businessman' => $this->string(32)->notNull()->comment('ИНН индивидуального предпринимателя'),
            'registration_number' => $this->string(32)->notNull()->comment('Номер ОГРНИП'),
            'tax_legal' => $this->string(32)->notNull()->comment('ИНН юридического лица'),
            'main_number' => $this->string(32)->notNull()->comment('Номер ОГРН'),
        ]);

        $this->addForeignKey("fk_user_profile_user", 'user_profile', "user_id", "user", "id", "RESTRICT", "RESTRICT");
        $this->createIndex('idx_user_profile_user_id', 'user_profile', 'user_id');

        $this->insert('user_profile', [
            'user_id' => $user_id,
            'insurance_number' => '000-000-000 00',
            'tax_businessman' => '000000000000000',
            'registration_number' => '0000000000000',
            'tax_legal' => '0000000000',
            'main_number' => '0000000000000',
        ]);

        $auth = Yii::$app->authManager;

        $this->initRole('rl_admin_security'); /* администратор безопасности */
        $this->initRole('rl_admin_system'); /* системный администратор */
        $this->initRole('rl_operator_electricity'); /* оператор ЛКЗ на подключение к электрическим сетям ФГУП "ГХК" */
        $this->initRole('rl_operator_warm'); /* оператор ЛКЗ на подключение к тепловым сетям ФГУП "ГХК" */
        $this->initRole('rl_operator_water'); /* оператор ЛКЗ на подключение к централизованным системам водоснабжения и водоотведения ФГУП "ГХК" */
        $this->initRole('rl_provider_electricity'); /* гарантирующий поставщик на подключение к электрическим сетям ФГУП "ГХК" */
        $this->initRole('rl_applicant'); /* заявитель */
        $adminRole = $this->initRole('rl_admin'); /* функциональный администратор */
        $auth->assign($adminRole, $user_id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->deleteRole('rl_admin'); /* функциональный администратор */
        $this->deleteRole('rl_admin_system'); /* системный администратор */
        $this->deleteRole('rl_admin_security'); /* администратор безопасности */
        $this->deleteRole('rl_operator_electricity'); /* оператор ЛКЗ на подключение к электрическим сетям ФГУП "ГХК" */
        $this->deleteRole('rl_operator_warm'); /* оператор ЛКЗ на подключение к тепловым сетям ФГУП "ГХК" */
        $this->deleteRole('rl_operator_water'); /* оператор ЛКЗ на подключение к централизованным системам водоснабжения и водоотведения ФГУП "ГХК" */
        $this->deleteRole('rl_provider_electricity'); /* гарантирующий поставщик на подключение к электрическим сетям ФГУП "ГХК" */
        $this->deleteRole('rl_applicant'); /* заявитель */
        $this->dropTable('user_profile');
        $this->delete('user');
    }

    /**
     * Init role
     * @param $roleName string Role name
     * @return null|\yii\rbac\Role Role if found, else create and return permission
     * @throws Exception
     */
    public function initRole($roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if (!$role) {
            $role = $auth->createRole($roleName);
            $auth->add($role);
        }
        return $role;
    }

    /**
     * Deletes role
     * @param $roleName string Role name
     * @return null|\yii\rbac\Role Role if found, else create and return permission
     * @throws Exception
     */
    public function deleteRole($roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role) {
            $auth->removeChildren($role);
            $auth->remove($role);
        }
    }
}
