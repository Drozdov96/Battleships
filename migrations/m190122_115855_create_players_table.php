<?php

use yii\db\Migration;

/**
 * Handles the creation of table `players`.
 */
class m190122_115855_create_players_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('players',[
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        return false;
    }
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
