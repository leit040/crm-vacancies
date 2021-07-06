<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test_task_file}}`.
 */
class m210625_090846_create_test_task_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_task_file}}', [
            'id' => $this->string(36)->notNull(),
            'file_path' => $this->string(512)->notNull(),
            'file_name' => $this->string(512)->notNull(),
            'test_task_id' => $this->string(36)->notNull(),
        ]);
        $this->addPrimaryKey('pk-test_task_file', '{{%test_task_file}}', 'id');
        $this->addForeignKey(
            'fk-test_task_file-test_task_id',
            '{{%test_task_file}}',
            'test_task_id',
            'test_task',
            'id',
            'CASCADE',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-test_task_file-test_task_id');
        $this->dropTable('{{%test_task_file}}');
    }
}
