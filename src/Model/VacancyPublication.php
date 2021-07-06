<?php

declare(strict_types=1);

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "vacancy_publication".
 *
 * @property string   $id
 * @property string   $url
 * @property int|null $views_count
 * @property int|null $response_count
 * @property string   $vacancy_id
 * @property Vacancy  $vacancy
 */
class VacancyPublication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_publication';
    }

    public static function create(string $url, int $viewsCount, int $responseCount, string $vacancyId): self
    {
        $model = new self();
        $model->id = Uuid::uuid6()->toString();
        $model->url = $url;
        $model->views_count = $viewsCount;
        $model->response_count = $responseCount;
        $model->vacancy_id = $vacancyId;

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'url', 'vacancy_id'], 'required'],
            [['views_count', 'response_count'], 'integer'],
            [['id', 'vacancy_id'], 'string', 'max' => 36],
            [['url'], 'string', 'max' => 1024],
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
            'url' => Yii::t('app', 'Url'),
            'views_count' => Yii::t('app', 'Views Count'),
            'response_count' => Yii::t('app', 'Response Count'),
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

    public function updateData(string $url, int $viewsCount, int $responseCount)
    {
        $this->url = $url;
        $this->views_count = $viewsCount;
        $this->response_count = $responseCount;
    }
}
