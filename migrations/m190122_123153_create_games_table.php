<?php

use yii\db\Migration;

/**
 * Handles the creation of table `games`.
 */
class m190122_123153_create_games_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('games', [
            'id' => $this->primaryKey(),
            'player_one' => $this->integer(),
            'player_two' => $this->integer(),
            'field_one' => $this->integer(),
            'field_two' => $this->integer(),
            'winner' => $this->integer(),
            'end_timestamp' => $this->timestamp()
        ]);

        foreach (['player_one', 'player_two', 'winner'] as $column){
            $this->addForeignKey(
                'fk-games-'.$column,
                'games',
                $column,
                'players',
                'id'
            );
        }

        foreach (['field_one', 'field_two'] as $column){
            $this->addForeignKey(
                'fk-games-'.$column,
                'games',
                $column,
                'fields',
                'id'
            );
        }
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
