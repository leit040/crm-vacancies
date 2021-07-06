<?php

declare(strict_types=1);

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "test_task_file".
 *
 * @property string $id
 * @property string $file_path
 * @property string $test_task_id
 * @property string $file_name
 */
class TestTaskFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_task_file}}';
    }

    public static function create(string $path, string $fileName, string $testTaskId): self
    {
        $model = new self();
        $model->id = Uuid::uuid6()->toString();
        $model->file_path = $path;
        $model->test_task_id = $testTaskId;
        $model->file_name = $fileName;

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_path', 'test_task_id', 'file_name'], 'required'],
            [['id', 'test_task_id'], 'string', 'max' => 36],
            [['file_path', 'file_name'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_path' => Yii::t('app', 'Pile Path'),
            'test_task_id' => Yii::t('app', 'Test Task ID'),
            'file_name' => Yii::t('app', 'file_name'),
        ];
    }
}
