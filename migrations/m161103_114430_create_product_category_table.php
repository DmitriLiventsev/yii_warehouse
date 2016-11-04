<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_category`.
 */
class m161103_114430_create_product_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_category', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11),
            'category_id' => $this->integer(11),
        ]);

        $this->addForeignKey("product_fk", "{{%product_category}}", "product_id", "{{%product}}", "id", 'CASCADE');
        $this->addForeignKey("category_fk", "{{%product_category}}", "category_id", "{{%category}}", "id", 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('product_category');
    }
}
