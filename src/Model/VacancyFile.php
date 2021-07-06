<?php

declare(strict_types=1);

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "vacancy_file".
 *
 * @property string  $id
 * @property string  $file_path
 * @property string  $file_name
 * @property string  $vacancy_id
 * @property Vacancy $vacancy
 */
class VacancyFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_file';
    }

    public static function create(string $path, string $fileName, string $vacancyId): self
    {
        $model = new self();
        $model->id = Uuid::uuid6()->toString();
        $model->file_path = $path;
        $model->vacancy_id = $vacancyId;
        $model->file_name = $fileName;

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_path', 'file_name', 'vacancy_id'], 'required'],
            [['id', 'vacancy_id'], 'string', 'max' => 36],
            [['file_path', 'file_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::class, 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file_path' => Yii::t('app', 'File Path'),
            'file_name' => Yii::t('app', 'File Name'),
            'vacancy_id' => Yii::t('app', 'Vacancy ID'),
        ];
    }

    /**
     * Gets query for [[Vacancy]].
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
    }
}
