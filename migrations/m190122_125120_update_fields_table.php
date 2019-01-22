<?php

use yii\db\Migration;

/**
 * Class m190122_125120_update_fields_table
 */
class m190122_125120_update_fields_table extends Migration
{
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

    public function up()
    {
        $this->addColumn('fields', 'game_id', $this->integer());

        $this->addForeignKey(
            'fk-fields-game-id',
            'fields',
            'game_id',
            'games',
            'id'
        );
    }

    public function down()
    {
        echo "m190122_125120_update_fields_table cannot be reverted.\n";

        return false;
    }

}
