<?php

use yii\db\Migration;

/**
 * Class m191010_183542_initial
 */
class m191010_183542_initial extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->text(),
            'content' => $this->text(),
            'user_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'email' => $this->string(255),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'password' => $this->text(),
            'salt' => $this->text(),
            'role' => $this->smallInteger()->notNull()->defaultValue(10),
            'type' => $this->smallInteger()->notNull()->defaultValue(10),
            'about' => $this->text(),
            'avatar' => $this->text(),
            'pinterest_link' => $this->string(255),
            'instagram_link' => $this->string(255),
            'facebook_link' => $this->string(255),
            'phone' => $this->string(255),
            'skype' => $this->string(255),
            'telegram' => $this->string(255),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'uuid' => $this->string(255)->unique(),
            'ext' => $this->string(255),
            'original_filename' => $this->string(255),
            'title' => $this->string(255),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('user_gallery_image',[
            'user_id' => $this->integer(),
            'gallery_id' => $this->integer(),
            'image_id' => $this->integer(),
            'PRIMARY KEY(user_id, gallery_id, image_id)',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191010_183542_initial cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191010_183542_initial cannot be reverted.\n";

        return false;
    }
    */
}
