<?php

use yii\db\Migration;

/**
 * Class m221204_084312_add_fk_data_table
 */
class m221204_084312_add_fk_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-data-parent_id',
            'data',
            'parent_id',
            'data',
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
            'fk-data-parent_id',
            'data'
        );
    }
}
