<?php

use yii\db\Migration;

/**
 * Class m191014_134104_post_add_description_column
 */
class m191014_134104_post_add_description_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191014_134104_post_add_description_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191014_134104_post_add_description_column cannot be reverted.\n";

        return false;
    }
    */
}
