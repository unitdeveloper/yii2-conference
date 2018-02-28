<?php

use yii\db\Migration;

/**
 * Handles the creation of table `participant`.
 */
class m180225_153455_create_participant_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%participant}}', [
            'id' => $this->primaryKey(),

            'name' => $this->string(),
            'email' => $this->string(),
        ], $tableOptions);

        $this->createIndex('idx-participant-name', '{{%participant}}', 'name');
        $this->createIndex('idx-participant-email', '{{%participant}}', 'email');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%participant}}');
    }
}
