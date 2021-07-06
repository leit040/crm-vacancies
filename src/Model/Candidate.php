<?php

declare(strict_types=1);

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "candidate".
 *
 * @property string      $id
 * @property string      $candidate_status
 * @property string      $full_name
 * @property string      $position
 * @property string      $phone
 * @property string|null $socials
 * @property string      $assign_to_id
 * @property string      $created_at
 * @property string      $vacancy_id
 * @property int|null    $is_responded
 * @property array       $files
 */
class Candidate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'candidate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'candidate_status', 'full_name', 'position', 'phone', 'assign_to_id', 'created_at', 'vacancy_id'], 'required'],
            [['socials'], 'string'],
            [['created_at'], 'safe'],
            [['is_responded'], 'integer'],
            [['id', 'assign_to_id', 'vacancy_id'], 'string', 'max' => 36],
            [['candidate_status', 'full_name'], 'string', 'max' => 512],
            [['position'], 'string', 'max' => 1024],
            [['phone'], 'string', 'max' => 256],
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
            'candidate_status' => Yii::t('app', 'Candidate Status'),
            'full_name' => Yii::t('app', 'Full Name'),
            'position' => Yii::t('app', 'Position'),
            'phone' => Yii::t('app', 'Phone'),
            'socials' => Yii::t('app', 'Socials'),
            'assign_to_id' => Yii::t('app', 'Assign To ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'vacancy_id' => Yii::t('app', 'Vacancy ID'),
            'is_responded' => Yii::t('app', 'Is Responded'),
        ];
    }

    public function getFiles()
    {
        return $this->hasMany(CandidateFile::class, ['candidate_id' => 'id']);
    }

    public function fields()
    {
        return [
            'id',
            'candidateStatus' => 'candidate_status',
            'fullName' => 'full_name',
            'position',
            'phone',
            'socials',
            'assignToId' => 'assign_to_id',
            'createdAt' => 'created_at',
            'vacancyId' => 'vacancy_id',
            'isResponded' => 'is_responded',
        ];
    }

    public function extraFields()
    {
        return [
            'files' => fn () => $this->files,
        ];
    }

    public static function create(string $candidateStatus,string $fullName, string $position, string $phone,
                                  string $socials, string $assignToId, string $vacancyId): self
    {
        $model = new self();
        $model->id = Uuid::uuid6()->toString();
        $model->created_at = new \yii\db\Expression('NOW()');
        $model->candidate_status = $candidateStatus;
        $model->full_name = $fullName;
        $model->position = $position;
        $model->phone = $phone;
        $model->socials = $socials;
        $model->assign_to_id = $assignToId;
        $model->vacancy_id = $vacancyId;
        $model->is_responded = false;

        return $model;
    }

    public function updateData(string $candidateStatus,string $fullName, string $position, string $phone,
                               string $socials, string $assignToId, string $vacancyId, bool $isResponded)
    {
        $this->candidate_status = $candidateStatus;
        $this->full_name = $fullName;
        $this->position = $position;
        $this->phone = $phone;
        $this->socials = $socials;
        $this->assign_to_id = $assignToId;
        $this->vacancy_id = $vacancyId;
        $this->is_responded = $isResponded;
    }
}
