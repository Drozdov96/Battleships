<?php

use yii\db\Migration;

/**
 * Handles the creation of table `fields`.
 */
class m190122_122125_create_fields_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('fields', [
            'id' => $this->primaryKey(),
            'owner' => $this->integer(),

        ]);

        $this->addForeignKey(
            'fk-fields-owner',
            'fields',
            'owner',
            'players',
            'id'
        );
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
