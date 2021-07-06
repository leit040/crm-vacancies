<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CandidateCreateForm;
use App\Form\CandidateFileCreateForm;
use App\Form\CandidateUpdateForm;
use app\Model\Candidate;
use App\Repository\CandidateRepository;
use App\Response\EmptyResponse;
use App\UseCase\CandidateManagementService;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class CandidateController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/candidate/index",
     *     tags={"Candidate"},
     *     summary="Get Candidates",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Candidate")),
     *              @OA\Property(property="_meta", type="object", ref="#/components/schemas/Meta"),
     *          )
     *     )
     * )
     */
    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Candidate::find(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/candidate/view",
     *     tags={"Candidate"},
     *     summary="Get specific Candidate",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Candidate")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Candidate id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )),
     *      *     @OA\Parameter(
     *         name="expand",
     *         in="query",
     *         description="files",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )),
     *     )
     * )
     */
    public function actionView(string $id, CandidateRepository $candidateRepository): Candidate
    {
        return $candidateRepository->get($id);
    }

    /**
     * @OA\Post(
     *     path="/candidate/create",
     *     tags={"Candidate"},
     *     summary="Create Candidate",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Candidate")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CandidateCreateForm"),
     *     )
     * )
     */
    public function actionCreate(CandidateManagementService $candidateManagementService, CandidateRepository $candidateRepository): CandidateCreateForm | Candidate
    {
        $form = new CandidateCreateForm();
        $this->load($form);
        if ($filesData = null !== \Yii::$app->getRequest()->getBodyParam('files')) {
            $form->files = ArrayHelper::getColumn($form->files, function ($arrayData) {
                return new CandidateFileCreateForm($arrayData);
            });
        }

        if ($form->validate()) {
            return $candidateManagementService->save($form);
        }

        return $form;
    }

    /**
     * @OA\Put(
     *     path="/candidate/update",
     *     tags={"Candidate"},
     *     summary="Update Candidate",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CandidateUpdateForm")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CandidateUpdateForm")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Candidate id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     )
     * )
     */
    public function actionUpdate(string $id, CandidateManagementService $candidateManagementService, CandidateRepository $candidateRepository): CandidateUpdateForm | Candidate
    {
        $model = $candidateRepository->get($id);
        $form = new CandidateUpdateForm();
        $this->load($form);
        if (($filesData = \Yii::$app->getRequest()->getBodyParam('files')) !== null) {
            $form->files = ArrayHelper::getColumn($filesData, function ($arrayData) {
                return new CandidateFileCreateForm($arrayData);
            });

            if ($form->validate()) {
                return $candidateManagementService->update($id, $form);
            }
        }

        return $form;
    }

    /**
     * @OA\Delete (
     *     path="/candidate/delete",
     *     tags={"Candidate"},
     *     summary="Delete Candidate",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Candidate id",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="successful operation"
     *     )
     * )
     */
    public function actionDelete(string $id, CandidateRepository $candidateRepository): EmptyResponse
    {
        $candidateRepository->delete($candidateRepository->get($id));

        return new EmptyResponse(204);
    }

    protected function verbs(): array
    {
        return [
            'create' => ['POST'],
            'update' => ['PUT'],
            'delete' => ['DELETE'],
            'index' => ['GET'],
            'view' => ['GET'],
        ];
    }
}
