<?php

use yii\db\Migration;

/**
 * Class m191110_140850_competition_add_image
 */
class m191110_140850_competition_add_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('competition', 'image_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191110_140850_competition_add_image cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191110_140850_competition_add_image cannot be reverted.\n";

        return false;
    }
    */
}
