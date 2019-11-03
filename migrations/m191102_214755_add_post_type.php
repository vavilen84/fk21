<?php

use yii\db\Migration;

/**
 * Class m191102_214755_add_post_type
 */
class m191102_214755_add_post_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'type', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191102_214755_add_post_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191102_214755_add_post_type cannot be reverted.\n";

        return false;
    }
    */
}
