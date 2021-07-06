<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\VacancyCreateForm;
use App\Form\VacancyFileCreateForm;
use App\Form\VacancyPublicationCreateForm;
use App\Form\VacancyUpdateForm;
use app\Model\Vacancy;
use App\Repository\VacancyRepository;
use App\Response\EmptyResponse;
use App\UseCase\VacancyManagementService;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class VacancyController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/vacancy/index",
     *     tags={"Vacancy"},
     *     summary="Get Vacancies",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/Vacancy")),
     *              @OA\Property(property="_meta", type="object", ref="#/components/schemas/Meta"),
     *          )
     *     )
     * )
     */
    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Vacancy::find(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/vacancy/view",
     *     tags={"Vacancy"},
     *     summary="Get specific Vacancy",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Vacancy")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Vacancy id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )),
     *          @OA\Parameter(
     *         name="expand",
     *         in="query",
     *         description="files,publications",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )),
     *     )
     * )
     */
    public function actionView(string $id, VacancyRepository $vacancyRepository): Vacancy
    {
        return $vacancyRepository->get($id);
    }

    /**
     * @OA\Post(
     *     path="/vacancy/create",
     *     tags={"Vacancy"},
     *     summary="Create Vacancy",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Vacancy")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VacancyCreateForm"),
     *     )
     * )
     */
    public function actionCreate(VacancyManagementService $vacancyManagementService, VacancyRepository $vacancyRepository): VacancyCreateForm | Vacancy
    {
        $form = new VacancyCreateForm();
        $this->load($form);
        if (($filesData = \Yii::$app->getRequest()->getBodyParam('files')) !== null) {
            $form->files = ArrayHelper::getColumn($filesData, function ($arrayData) {
                return new VacancyFileCreateForm($arrayData);
            });
        }
        if (($PublicationsData = \Yii::$app->getRequest()->getBodyParam('publications')) !== null) {
            $form->publications = ArrayHelper::getColumn($PublicationsData, function ($arrayData) {
                return new VacancyPublicationCreateForm($arrayData);
            });
        }

        if ($form->validate()) {
            return $vacancyManagementService->save($form);
        }

        return $form;
    }

    /**
     * @OA\Put(
     *     path="/vacancy/update",
     *     tags={"Vacancy"},
     *     summary="Update Vacancy",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/VacancyUpdate")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/VacancyUpdateForm")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Vacancy id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     )
     * )
     */
    public function actionUpdate(string $id, VacancyManagementService $vacancyManagementService, VacancyRepository $vacancyRepository): VacancyUpdateForm | Vacancy
    {
        $model = $vacancyRepository->get($id);
        $form = new VacancyUpdateForm();
        $this->load($form);
        if (($filesData = \Yii::$app->getRequest()->getBodyParam('files')) !== null) {
            $form->files = ArrayHelper::getColumn($filesData, function ($arrayData) {
                return new VacancyFileCreateForm($arrayData);
            });
            if (($PublicationsData = \Yii::$app->getRequest()->getBodyParam('publications')) !== null) {
                $form->publications = ArrayHelper::getColumn($PublicationsData, function ($arrayData) {
                    return new VacancyPublicationCreateForm($arrayData);
                });
            }

            if ($form->validate()) {
                return $vacancyManagementService->update($id, $form);
            }
        }

        return $form;
    }

    /**
     * @OA\Delete (
     *     path="/vacancy/delete",
     *     tags={"Vacancy"},
     *     summary="Delete Vacancy",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Vacancy id",
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
    public function actionDelete(string $id, VacancyRepository $vacancyRepository): EmptyResponse
    {
        $vacancyRepository->delete($vacancyRepository->get($id));

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
