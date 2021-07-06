<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Vacancy;
use yii\web\NotFoundHttpException;

class ARVacancyRepository implements VacancyRepository
{
    public function get(string $id): Vacancy
    {
        if (($model = Vacancy::findOne($id)) === null) {
            throw new NotFoundHttpException(sprintf("Vacancy not found with id '%s'", $id));
        }

        return $model;
    }

    public function store(Vacancy $vacancy): void
    {
        $vacancy->save(false);
    }

    public function delete(Vacancy $vacancy): void
    {
        $vacancy->beforeDelete();
        Vacancy::deleteAll(['id' => $vacancy->id]);
        $vacancy->afterDelete();
    }
}
