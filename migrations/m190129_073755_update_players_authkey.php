<?php

use yii\db\Migration;

/**
 * Class m190129_073755_update_players_authkey
 */
class m190129_073755_update_players_authkey extends Migration
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
        echo "m190129_073755_update_players_authkey cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('players', 'authkey',
            $this->string(124)->unique());
    }

    public function down()
    {
        echo "m190129_073755_update_players_authkey cannot be reverted.\n";

        return false;
    }

}
