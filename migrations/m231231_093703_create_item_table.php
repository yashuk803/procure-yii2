<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item}}`.
 */
class m231231_093703_create_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('items', [
            'id' => $this->primaryKey(),
            'purchase_id' => $this->integer()->notNull(),
            'description' => $this->string(255)->notNull(),
            'quantity' => $this->integer()->notNull(),
            'unit' => $this->string(50)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-items-purchase_id',
            'items',
            'purchase_id',
            'purchases',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-item-purchases_id', 'items');
        $this->dropTable('{{%items}}');
    }
}
