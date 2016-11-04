<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m161103_114040_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128),
            'picture' => $this->string(128),
            'description' => $this->string(256),
            'price' => $this->integer(11),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product');
    }
}
