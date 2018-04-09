<?php

use yii\db\Migration;

/**
 * Handles the creation of table `letter`.
 */
class m180319_115553_create_letter_table extends Migration
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

        $this->createTable('{{%letter}}', [
            'id'               => $this->primaryKey(),
            'created_at'       => $this->date()->notNull(),
            'participant_id'   => $this->integer(),
            'material_id'      => $this->integer(),
            'conference_id'    => $this->integer(),
            'user_id'          => $this->integer(),
            'application_id'   => $this->integer(),
            'email'            => $this->string(),
            'status'           => $this->smallInteger()->defaultValue(0),
            'message'          => $this->text(),
        ], $tableOptions);

        $this->addForeignKey('fk-value-letter-conference', '{{%letter}}', 'conference_id', '{{%conference}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-letter-user', '{{%letter}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-letter-participant', '{{%letter}}', 'participant_id', '{{%participant}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-letter-material', '{{%letter}}', 'material_id', '{{%material}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-letter-application', '{{%letter}}', 'application_id', '{{%application}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%letter}}');
    }
}
