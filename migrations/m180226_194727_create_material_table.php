<?php

use yii\db\Migration;

/**
 * Handles the creation of table `material`.
 */
class m180226_194727_create_material_table extends Migration
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

        $this->createTable('{{%material}}', [
            'id'            => $this->primaryKey(),
            'category_id'   => $this->integer(),
            'conference_id' => $this->integer(),
            'participant_id'=> $this->integer(),

            'created_at'   => $this->date()->notNull(),
            'updated_at'   => $this->date(),
            'publisher_at' => $this->date(),

            'udk'           => $this->string(),
            'author'        => $this->string(),
            'university'    => $this->string(),
            'email'         => $this->string(),
            'material_name' => $this->string(),

            'ru_annotation' => $this->text(),
            'ua_annotation' => $this->text(),
            'us_annotation' => $this->text(),

            'ru_tag' => $this->text(),
            'ua_tag' => $this->text(),
            'us_tag' => $this->text(),

            'top_anotation' => $this->text(),
            'top_tag'       => $this->text(),

            'material_html' => $this->text(),

            'status_publisher' => $this->smallInteger()->defaultValue(0),

            'dir' => $this->string()->notNull(),

            'word_file' => $this->string(),
            'pdf_file' => $this->string(),
            'html_file' => $this->string(),

        ], $tableOptions);

        $this->createIndex('idx-material-status_publisher', '{{%material}}', 'status_publisher');

        $this->createIndex('idx-material-udk', '{{%material}}', 'udk');
        $this->createIndex('idx-material-author', '{{%material}}', 'author');
        $this->createIndex('idx-material-university', '{{%material}}', 'university');
        $this->createIndex('idx-material-email', '{{%material}}', 'email');
        $this->createIndex('idx-material-material_name', '{{%material}}', 'material_name');

        $this->addForeignKey('fk-value-category', '{{%material}}', 'category_id', '{{%category}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-conference', '{{%material}}', 'conference_id', '{{%conference}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-value-participant', '{{%material}}', 'participant_id', '{{%participant}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%material}}');
    }
}
