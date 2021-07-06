<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Candidate;
use yii\web\NotFoundHttpException;

class ARCandidateRepository implements CandidateRepository
{
    public function get(string $id): Candidate
    {
        if (($model = Candidate::findOne($id)) === null) {
            throw new NotFoundHttpException(sprintf("Candidate not found with id '%s'", $id));
        }

        return $model;
    }

    public function store(Candidate $candidate): void
    {
        $candidate->save(false);
    }

    public function delete(Candidate $candidate): void
    {
        $candidate->beforeDelete();
        Candidate::deleteAll(['id' => $candidate->id]);
        $candidate->afterDelete();
    }
}
