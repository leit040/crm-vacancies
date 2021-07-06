<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\TestTask;
use yii\web\NotFoundHttpException;

class ARTestTaskRepository implements _TestTaskRepository
{
    public function get(string $id): TestTask
    {
        if (($model = TestTask::findOne($id)) === null) {
            throw new NotFoundHttpException(sprintf("testTask not found with id '%s'", $id));
        }

        return $model;
    }

    public function store(TestTask $testTask): void
    {
        $testTask->save(false);
    }

    public function delete(TestTask $testTask): void
    {
        $testTask->beforeDelete();
        TestTask::deleteAll(['id' => $testTask->id]);
        $testTask->afterDelete();
    }
}
