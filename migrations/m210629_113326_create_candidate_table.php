<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%candidate}}`.
 */
class m210629_113326_create_candidate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%candidate}}', [
            'id' => $this->string(36)->notNull(),
            'candidate_status' => $this->string(512)->notNull(),
            'full_name' => $this->string(512)->notNull(),
            'position' => $this->string(1024)->notNull(),
            'phone' => $this->string(256)->notNull(),
            'socials' => $this->text(),
            'assign_to_id' => $this->string(36)->notNull(),
            'created_at' => $this->date()->notNull(),
            'vacancy_id' => $this->string(36)->notNull(),
            'is_responded' => $this->boolean(),
        ]);
        $this->addPrimaryKey('pk-candidate', '{{%candidate}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%candidate}}');
    }
}
