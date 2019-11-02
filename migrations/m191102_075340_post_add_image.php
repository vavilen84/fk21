<?php

use yii\db\Migration;

/**
 * Class m191102_075340_post_add_image
 */
class m191102_075340_post_add_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'image_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191102_075340_post_add_image cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191102_075340_post_add_image cannot be reverted.\n";

        return false;
    }
    */
}
