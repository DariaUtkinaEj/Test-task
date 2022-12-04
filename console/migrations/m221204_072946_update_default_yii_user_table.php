<?php

use yii\db\Migration;

/**
 * Class m221204_072946_update_default_yii_user_table
 */
class m221204_072946_update_default_yii_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'auth_expires_at', $this->integer()->notNull());
        $this->dropColumn('user', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'auth_expires_at');
        $this->addColumn('user', 'email', $this->string(255)->notNull());
    }
}
