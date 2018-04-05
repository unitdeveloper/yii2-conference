<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m180104_193959_create_category_table extends Migration
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

        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'conference_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('idx-category-name', '{{%category}}', 'name');

        $this->addForeignKey('fk-category-conference_id', '{{%category}}', 'conference_id', '{{%conference}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%category}}');
    }
}
