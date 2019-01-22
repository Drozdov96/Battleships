<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cells`.
 */
class m190122_125838_create_cells_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('cells', [
            'id' => $this->PrimaryKey(),
            'coordinate_x' => $this->integer(),
            'coordinate_y' => $this->integer(),
            'state' => $this->char(8),
            'field' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-cells-field',
            'cells',
            'field',
            'fields',
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
