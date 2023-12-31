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
        $this->createTable('item', [
            'id' => $this->primaryKey(),
            'purchase_id' => $this->integer()->notNull(),
            'description' => $this->string(255)->notNull(),
            'quantity' => $this->integer()->notNull(),
            'unit' => $this->string(50)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-item-purchase_id',
            'item',
            'purchase_id',
            'purchase',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-item-purchase_id', 'item');
        $this->dropTable('{{%item}}');
    }
}
