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
            'conference_id'    => $this->integer(),
            'category_id'      => $this->integer(),
            'user_id'          => $this->integer(),

            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'surname' => $this->string(),
            'degree' => $this->string(),
            'position' => $this->string(),
            'work_place' => $this->string(),
            'address_speaker' => $this->string(),
            'phone' => $this->integer(20),
            'email' => $this->string(),
            'title_report' => $this->string(),
            'surnames_co_authors' => $this->string(),

            'status'           => $this->smallInteger()->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('fk-value-application-participant', '{{%application}}', 'participant_id', '{{%participant}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-application-conference', '{{%application}}', 'conference_id', '{{%conference}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-application-material', '{{%application}}', 'material_id', '{{%material}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-application-category', '{{%application}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-application-user', '{{%application}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application}}');
    }
}
