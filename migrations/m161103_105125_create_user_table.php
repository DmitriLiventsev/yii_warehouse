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

        $user = new User();
        $user->username = 'demo';
        $user->password = Yii::$app->getSecurity()->generatePasswordHash('demo');
        $user->save();

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
