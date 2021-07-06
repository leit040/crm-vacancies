<?php

declare(strict_types=1);

namespace App\Model;

use Ramsey\Uuid\Uuid;
use Yii;

/**
 * This is the model class for table "candidate_file".
 *
 * @property string        $id
 * @property string        $file_path
 * @property string        $file_name
 * @property string        $candidate_id
 * @property CandidateFile $candidate
 */
class CandidateFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'candidate_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_path', 'file_name', 'candidate_id'], 'required'],
            [['id', 'candidate_id'], 'string', 'max' => 36],
            [['file_path', 'file_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['candidate_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['candidate_id' => 'id']],
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
            'candidate_id' => Yii::t('app', 'Candidate ID'),
        ];
    }

    /**
     * Gets query for [[Candidate]].
     */
    public function getCandidate()
    {
        return $this->hasOne(self::class, ['id' => 'candidate_id']);
    }

    public static function create(string $path, string $fileName, string $candidateId): self
    {
        $model = new self();
        $model->id = Uuid::uuid6()->toString();
        $model->file_path = $path;
        $model->candidate_id = $candidateId;
        $model->file_name = $fileName;

        return $model;
    }
}
