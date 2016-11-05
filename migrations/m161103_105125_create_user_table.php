<?php

use app\models\User;
use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m161103_105125_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50),
            'password' => $this->string(64),
            'auth_key' => $this->string(64),
            'access_tokent' => $this->string(64),
            'UNIQUE KEY `username` (`username`)',
        ]);

        $this->insert('user', [
            'username' => 'demo',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('demo')
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
