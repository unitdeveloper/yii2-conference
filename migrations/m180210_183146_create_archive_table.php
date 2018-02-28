<?php

use yii\db\Migration;

/**
 * Handles the creation of table `archive`.
 */
class m180210_183146_create_archive_table extends Migration
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

        $this->createTable('{{%archive}}', [
            'id' => $this->primaryKey(),
            'pdf_file' => $this->string(),
            'image' => $this->string(),
            'active' => $this->smallInteger()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%archive}}');
    }
}
