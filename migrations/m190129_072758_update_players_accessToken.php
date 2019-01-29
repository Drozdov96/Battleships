<?php

use yii\db\Migration;

/**
 * Class m190129_072758_update_players_accessToken
 */
class m190129_072758_update_players_accessToken extends Migration
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
        echo "m190129_072758_update_players_accessToken cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('players', 'accessToken',
            $this->string(124)->unique());
    }

    public function down()
    {
        echo "m190129_072758_update_players_accessToken cannot be reverted.\n";

        return false;
    }

}
