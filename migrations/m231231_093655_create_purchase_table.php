<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%purchase}}`.
 */
class m231231_093655_create_purchase_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('purchases', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'budget' => $this->decimal(10, 2)->notNull(),
            'status_id' => $this->tinyInteger()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-purchases-user_id',
            'purchases',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-purchases-user_id', 'purchases');
        $this->dropTable('{{%purchases}}');
    }
}
