<?php

use yii\db\Migration;

/**
 * Class m191015_182601_user_add_reset_password_token_column
 */
class m191015_182601_user_add_reset_password_token_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'password_reset_token', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191015_182601_user_add_reset_password_token_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191015_182601_user_add_reset_password_token_column cannot be reverted.\n";

        return false;
    }
    */
}
