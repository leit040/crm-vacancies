<?php

declare(strict_types=1);

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "test_task".
 *
 * @property string $id
 * @property string $position
 * @property string $brief_id
 * @property string $description
 * @property array  $files
 */
class TestTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_task}}';
    }

    public static function create(string $position, string $description, string $briefId): self
    {
        $model = new self();
        $model->id = Uuid::uuid6()->toString();
        $model->description = $description;
        $model->position = $position;
        $model->brief_id = $briefId;

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'position', 'brief_id', 'description'], 'required'],
            [['description'], 'string'],
            [['id', 'brief_id'], 'string', 'max' => 36],
            [['position'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'position' => Yii::t('app', 'Position'),
            'brief_id' => Yii::t('app', 'BriefID'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function getFiles(): \yii\db\ActiveQuery
    {
        return $this->hasMany(TestTaskFile::class, ['test_task_id' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'position',
            'description',
            'briefId' => 'brief_id',
        ];
    }

    public function extraFields()
    {
        return [
            'files' => fn () => $this->files,
        ];
    }

    public function updateData(string $position, string $description, string $briefId)
    {
        $this->description = $description;
        $this->position = $position;
        $this->brief_id = $briefId;
    }
}
