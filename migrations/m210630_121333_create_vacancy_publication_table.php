<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy_publication}}`.
 */
class m210630_121333_create_vacancy_publication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy_publication}}', [
            'id' => $this->string(36)->notNull(),
            'url' => $this->string(1024)->notNull(),
            'views_count' => $this->integer(),
            'response_count' => $this->integer(),
            'vacancy_id' => $this->string(36)->notNull(),
        ]);
        $this->addPrimaryKey('pk-vacancy_publication', '{{%vacancy_publication}}', 'id');
        $this->addForeignKey(
            'fk-vacancy_publication-vacancy_id',
            '{{%vacancy_publication}}',
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
        $this->dropForeignKey('fk-vacancy_publication-vacancy_id', '{{%vacancy_publication}}');
        $this->dropTable('{{%vacancy_publication}}', );
    }
}
