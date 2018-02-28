<?php

use yii\db\Migration;

/**
 * Handles the creation of table `fragment`.
 */
class m180210_150620_create_fragment_table extends Migration
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

        $this->createTable('{{%fragment}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'header' => $this->string(),
            'content' => $this->text(),
        ]);

        $this->createIndex('idx-fragment-name', '{{%fragment}}', 'name');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%fragment}}');
    }
}
