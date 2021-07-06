<?php

declare(strict_types=1);

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "vacancy".
 *
 * @property string               $id
 * @property string               $name
 * @property string               $position
 * @property string               $rate
 * @property int|null             $count
 * @property string               $vacancy_status
 * @property string|null          $vacancy_type
 * @property int|null             $is_remote
 * @property string|null          $description
 * @property string               $assign_to_id
 * @property string               $created_at
 * @property string|null          $updated_at
 * @property VacancyFile[]        $vacancyFiles
 * @property VacancyPublication[] $vacancyPublications
 */
class Vacancy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vacancy}}';
    }

    public static function create(string $name, string $position, string $rate, int $count, string $vacancyStatus, string $vacancyType,
                                  bool $isRemote, string $description, string $assignTo): self
    {
        $model = new self();
        $model->id = $model->id = Uuid::uuid6()->toString();
        $model->name = $name;
        $model->position = $position;
        $model->rate = $rate;
        $model->count = $count;
        $model->vacancy_status = $vacancyStatus;
        $model->vacancy_type = $vacancyType;
        $model->is_remote = $isRemote;
        $model->description = $description;
        $model->assign_to_id = $assignTo;
        $model->created_at = new \yii\db\Expression('NOW()');

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'position', 'rate', 'vacancy_status', 'assign_to_id', 'created_at', 'description'], 'required'],
            [['count', 'is_remote'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'assign_to_id'], 'string', 'max' => 36],
            [['name', 'vacancy_status'], 'string', 'max' => 512],
            [['position'], 'string', 'max' => 1024],
            [['rate'], 'string', 'max' => 256],
            [['vacancy_type'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'position' => Yii::t('app', 'Position'),
            'rate' => Yii::t('app', 'Rate'),
            'count' => Yii::t('app', 'Count'),
            'vacancy_status' => Yii::t('app', 'Vacancy Status'),
            'vacancy_type' => Yii::t('app', 'Vacancy Type'),
            'is_remote' => Yii::t('app', 'Is Remote'),
            'description' => Yii::t('app', 'Description'),
            'assign_to_id' => Yii::t('app', 'Assign To ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[VacancyFiles]].
     */
    public function getVacancyFiles()
    {
        return $this->hasMany(VacancyFile::class, ['vacancy_id' => 'id']);
    }

    /**
     * Gets query for [[VacancyPublications]].
     */
    public function getVacancyPublications(): \yii\db\ActiveQuery
    {
        return $this->hasMany(VacancyPublication::class, ['vacancy_id' => 'id']);
    }

    public function updateData(string $name, string $position, string $rate, int $count, string $vacancyStatus, string $vacancyType,
                               bool $isRemote, string $description, string $assignTo)
    {
        $this->name = $name;
        $this->position = $position;
        $this->rate = $rate;
        $this->count = $count;
        $this->vacancy_status = $vacancyStatus;
        $this->vacancy_type = $vacancyType;
        $this->is_remote = $isRemote;
        $this->description = $description;
        $this->assign_to_id = $assignTo;
        $this->updated_at = new \yii\db\Expression('NOW()');
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'position',
            'rate',
            'count',
            'vacancyStatus' => 'vacancy_status',
            'vacancyType' => 'vacancy_type',
            'isRemote' => 'is_remote',
            'description',
            'assignTo' => 'assign_to_id',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];
    }

    public function extraFields()
    {
        return [
            'files' => fn () => $this->vacancyFiles,
            'publications' => fn () => $this->vacancyPublications,
        ];
    }
}
