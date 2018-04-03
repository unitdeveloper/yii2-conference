<?php

use yii\db\Migration;

/**
 * Handles the creation of table `conference`.
 */
class m180208_125041_create_conference_table extends Migration
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

        $this->createTable('{{%conference}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->smallInteger()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('idx-conference-name', '{{%conference}}', 'name');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%conference}}');
    }
}
