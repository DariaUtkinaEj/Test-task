<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m221204_094828_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'time_usage' => $this->decimal(20, 10),
            'memory_usage' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addColumn('data', 'request_id', $this->integer()->notNull());

        $this->addForeignKey(
            'fk-data-request_id',
            'data',
            'request_id',
            'request',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-data-request_id',
            'data'
        );

        $this->dropColumn('data', 'request_id');

        $this->dropTable('{{%request}}');
    }
}
