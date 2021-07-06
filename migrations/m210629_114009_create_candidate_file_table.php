<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%candidate_file}}`.
 */
class m210629_114009_create_candidate_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%candidate_file}}', [
            'id' => $this->string(36)->notNull(),
            'file_path' => $this->string()->notNull(),
            'file_name' => $this->string()->notNull(),
            'candidate_id' => $this->string(36)->notNull(),
        ]);
        $this->addPrimaryKey('pk-candidate_file', '{{%candidate_file}}', 'id');
        $this->addForeignKey(
            'fk-candidate_file-candidate_id',
            '{{%candidate_file}}',
            'candidate_id',
            '{{%candidate}}',
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
        $this > $this->dropForeignKey('fk-candidate_file-candidate_id');
        $this->dropTable('{{%candidate_file}}');
    }
}
