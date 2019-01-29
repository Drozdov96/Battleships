<?php

use yii\db\Migration;

/**
 * Class m190129_073542_update_players_password
 */
class m190129_073542_update_players_password extends Migration
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
        echo "m190129_073542_update_players_password cannot be reverted.\n";

        return false;
    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('players', 'password',
            $this->string(255));
    }

    public function down()
    {
        echo "m190129_073542_update_players_password cannot be reverted.\n";

        return false;
    }

}
