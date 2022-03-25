<?php

use yii\db\Migration;

/**
 * Class m220316_013351_adding_a_table_of_request_for_connection_to_the_power_grid
 */
class m220316_013351_adding_a_table_of_request_for_connection_to_the_power_grid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('electricity', [
            'id' => $this->primaryKey()->comment('Id'),
            'connection' => $this->integer()->comment('Тип подключения'),
            'management' => $this->integer()->comment('Способ документооборота'),
            'applicant' => $this->integer()->comment('Статус заявителя'),
            'status' => $this->integer()->comment('Статус заявки'),
            'created_at' => 'timestamp not null',
            'updated_at' => 'timestamp not null',
            'user_last' => $this->string(32)->comment('Последний пользователь'),
            'user_first' => $this->string(32)->comment('Создавший пользователь')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('electricity');
    }
}