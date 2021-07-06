<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Form\TestTaskUpdateForm;
use App\Form\VacancyPublicationCreateForm;
use app\Model\TestTask;
use App\Model\TestTaskFile;
use App\Model\TransactionManager;
use App\Repository\_TestTaskRepository;
use yii\helpers\ArrayHelper;

final class TestTaskManagementService
{
    private _TestTaskRepository $TestTaskRepository;

    public function __construct(TransactionManager $transactionManager, _TestTaskRepository $TestTaskRepository)
    {
        $this->TestTaskRepository = $TestTaskRepository;
    }

    public function save(VacancyPublicationCreateForm $form): TestTask
    {
        $testTask = TestTask::create($form->position, $form->description, $form->briefId);
        $this->TestTaskRepository->store($testTask);

        foreach ($form->files as $file) {
            $model = TestTaskFile::create($file->path, $file->fileName, $testTask->id);
            $model->save(false);
        }

        return $testTask;
    }

    public function update(string $testTaskId, TestTaskUpdateForm $form): TestTask
    {
        $testTask = $this->TestTaskRepository->get($testTaskId);
        $testTask->updateData($form->position, $form->description, $form->briefId);
        $oldIDs = ArrayHelper::map($testTask->files, 'id', 'id');
        $deleteIDs = array_diff($oldIDs, ArrayHelper::map($form->files, 'id', 'id'));

        if (!empty($deleteIDs)) {
            TestTaskFile::deleteAll(['id' => $deleteIDs]);
        }
        $this->TestTaskRepository->store($testTask);

        foreach ($form->files as $file) {
            if ('' === $file->id) {
                $model = TestTaskFile::create($file->path, $file->fileName, $testTaskId);
                $model->save(false);
            }
        }

        return $testTask;
    }
}
