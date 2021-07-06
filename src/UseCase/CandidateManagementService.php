<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Form\CandidateCreateForm;
use App\Form\CandidateUpdateForm;
use app\Model\Candidate;
use App\Model\CandidateFile;
use App\Repository\CandidateRepository;
use yii\helpers\ArrayHelper;

final class CandidateManagementService
{
    private CandidateRepository $candidateRepository;

    public function __construct(CandidateRepository $candidateRepository)
    {
        $this->candidateRepository = $candidateRepository;
    }

    public function save(CandidateCreateForm $form): Candidate
    {
        $candidate = Candidate::create($form->candidateStatus, $form->fullName, $form->position, $form->phone, $form->socials, $form->assignToId, $form->vacancyId);
        $this->candidateRepository->store($candidate);

        foreach ($form->files as $file) {
            $model = CandidateFile::create($file->path, $file->fileName, $candidate->id);
            $model->save(false);
        }

        return $candidate;
    }

    public function update(string $candidateId, CandidateUpdateForm $form): Candidate
    {
        $candidate = $this->candidateRepository->get($candidateId);
        $candidate->updateData($form->candidateStatus, $form->fullName, $form->position, $form->phone, $form->socials, $form->assignToId, $form->vacancyId, $form->isResponded);
        $oldIDs = ArrayHelper::map($candidate->files, 'id', 'id');
        $deleteIDs = array_diff($oldIDs, ArrayHelper::map($form->files, 'id', 'id'));

        if (!empty($deleteIDs)) {
            CandidateFile::deleteAll(['id' => $deleteIDs]);
        }
        $this->candidateRepository->store($candidate);

        foreach ($form->files as $file) {
            if ('' === $file->id) {
                $model = CandidateFile::create($file->path, $file->fileName, $candidateId);
                $model->save(false);
            }
        }

        return $candidate;
    }
}
