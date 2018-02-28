<?php

use yii\db\Migration;

/**
 * Handles the creation of table `config`.
 */
class m180216_132919_create_config_table extends Migration
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


        $this->createTable('{{%config}}', [
            'id' => $this->primaryKey(),
            'param' => $this->string()->notNull(),
            'value' => $this->text()->notNull(),
            'default' => $this->text()->notNull(),
            'label' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
        ], $tableOptions);

        $this->createIndex('idx-config-param', '{{%config}}', 'param');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%config}}');
    }
}
