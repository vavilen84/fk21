<?php

use yii\db\Migration;

/**
 * Class m191027_080111_add_competition_tables
 */
class m191027_080111_add_competition_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('competition', [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'content' => $this->text(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'deadline_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('competition_user_image', [
            'competition_id' => $this->integer(),
            'user_id' => $this->integer(),
            'image_id' => $this->integer(),
            'PRIMARY KEY(competition_id, user_id)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191027_080111_add_competition_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191027_080111_add_competition_tables cannot be reverted.\n";

        return false;
    }
    */
}
