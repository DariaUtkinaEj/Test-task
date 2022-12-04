<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%data}}`.
 */
class m221204_114207_add_nesting_level_column_to_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('data', 'nesting_level', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('data', 'nesting_level');
    }
}
