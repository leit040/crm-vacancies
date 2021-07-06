<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test_task}}`.
 */
class m210625_090630_create_test_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_task}}', [
            'id' => $this->string(36)->notNull(),
            'position' => $this->string(1024)->notNull(),
            'brief_id' => $this->string(36)->notNull(),
            'description' => $this->text()->notNull(),
        ]);

        $this->addPrimaryKey('pk-test_task', '{{%test_task}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%test_task}}');
    }
}
