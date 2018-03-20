<?php

use yii\db\Migration;

/**
 * Handles the creation of table `application`.
 */
class m180319_131223_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'created_at'       => $this->date()->notNull(),
            'participant_id'   => $this->integer(),
            'material_id'      => $this->integer(),
            'status'           => $this->smallInteger()->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('fk-value-application-participant', '{{%application}}', 'participant_id', '{{%participant}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-application-material', '{{%application}}', 'material_id', '{{%material}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application}}');
    }
}
