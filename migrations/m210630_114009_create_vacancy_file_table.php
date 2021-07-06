<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_file}}`.
 */
class m210630_114009_create_vacancy_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_file}}', [
            'id' => $this->string(36)->notNull(),
            'file_path' => $this->string()->notNull(),
            'file_name' => $this->string()->notNull(),
            'vacancy_id' => $this->string(36)->notNull(),
        ]);
        $this->addPrimaryKey('pk-vacancy_file', '{{%vacancy_file}}', 'id');
        $this->addForeignKey(
            'fk-vacancy_file-vacancy_id',
            '{{%vacancy_file}}',
            'vacancy_id',
            '{{%vacancy}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this > $this->dropForeignKey('fk-vacancy_file-vacancy_id', '{{%vacancy_file}}');
        $this->dropTable('{{%vacancy_file}}');
    }
}
