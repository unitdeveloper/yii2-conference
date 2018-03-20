<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mail_template`.
 */
class m180318_152002_create_mail_template_table extends Migration
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

        $this->createTable('{{%mail_template}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string()->notNull(),
            'body' => $this->text()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-mail_template-slug', '{{%mail_template}}', 'slug');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mail_template}}');
    }
}
