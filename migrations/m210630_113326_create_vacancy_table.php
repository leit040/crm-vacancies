<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacancy}}`.
 */
class m210630_113326_create_vacancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacancy}}', [
            'id' => $this->string(36)->notNull(),
            'name' => $this->string(512)->notNull(),
            'position' => $this->string(1024)->notNull(),
            'rate' => $this->string(256)->notNull(),
            'count' => $this->integer(),
            'vacancy_status' => $this->string(512)->notNull(),
            'vacancy_type' => $this->string(255),
            'is_remote' => $this->boolean(),
            'description' => $this->text(),
            'assign_to_id' => $this->string(36)->notNull(),
            'created_at' => $this->date()->notNull(),
            'updated_at' => $this->date(),
        ]);
        $this->addPrimaryKey('pk-vacancy', '{{%vacancy}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vacancy}}');
    }
}
