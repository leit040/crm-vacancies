<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Form\VacancyCreateForm;
use App\Form\VacancyUpdateForm;
use app\Model\Vacancy;
use App\Model\VacancyFile;
use App\Model\VacancyPublication;
use App\Repository\VacancyRepository;
use yii\helpers\ArrayHelper;

final class VacancyManagementService
{
    private VacancyRepository $vacancyRepository;

    public function __construct(VacancyRepository $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function save(VacancyCreateForm $form): Vacancy
    {
        $vacancy = Vacancy::create($form->name, $form->position, $form->rate, $form->count, $form->vacancyStatus, $form->vacancyType,
            $form->isRemote, $form->description, $form->assignTo);
        $this->vacancyRepository->store($vacancy);

        foreach ($form->files as $file) {
            $model = VacancyFile::create($file->path, $file->fileName, $vacancy->id);
            $model->save(false);
        }

        foreach ($form->publications as $publication) {
            $model = VacancyPublication::create($publication->url, $publication->viewsCount, $publication->responseCount, $vacancy->id);
            $model->save(false);
        }

        return $vacancy;
    }

    public function update(string $vacancyId, VacancyUpdateForm $form): Vacancy
    {
        $vacancy = $this->vacancyRepository->get($vacancyId);
        $vacancy->updateData($form->name, $form->position, $form->rate, $form->count, $form->vacancyStatus, $form->vacancyType,
            $form->isRemote, $form->description, $form->assignTo);
        $this->vacancyRepository->store($vacancy);
        $oldIDs = ArrayHelper::map($vacancy->vacancyFiles, 'id', 'id');
        $deleteIDs = array_diff($oldIDs, ArrayHelper::map($form->files, 'id', 'id'));

        if (!empty($deleteIDs)) {
            VacancyFile::deleteAll(['id' => $deleteIDs]);
        }
        foreach ($form->files as $file) {
            if ('' === $file->id) {
                $model = VacancyFile::create($file->path, $file->fileName, $vacancyId);
                $model->save(false);
            }
        }
        $oldPublicationsIDs = ArrayHelper::map($vacancy->vacancyPublications, 'id', 'id');
        $deletePublicationsIDs = array_diff($oldPublicationsIDs, ArrayHelper::map($form->publications, 'id', 'id'));

        if (!empty($deletePublicationsIDs)) {
            VacancyPublication::deleteAll(['id' => $deletePublicationsIDs]);
        }
        foreach ($form->publications as $publication) {
            if ('' === $publication->id) {
                $model = VacancyPublication::create($publication->url, $publication->viewsCount, $publication->responseCount, $vacancyId);
                $model->save(false);
            } else {
                $model = VacancyPublication::findOne($publication->id);
                $model->updateData($publication->url, $publication->viewsCount, $publication->responseCount);
                $model->save(false);
            }
        }

        return $vacancy;
    }
}
