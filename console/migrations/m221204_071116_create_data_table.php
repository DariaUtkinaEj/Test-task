<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%data}}`.
 */
class m221204_071116_create_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%data}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'key' => $this->string(255),
            'type' => $this->string(255),
            'value' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%data}}');
    }
}
