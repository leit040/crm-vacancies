<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\TestTaskFileCreateForm;
use App\Form\TestTaskUpdateForm;
use App\Form\VacancyPublicationCreateForm;
use app\Model\TestTask;
use App\Repository\_TestTaskRepository;
use App\Response\EmptyResponse;
use App\UseCase\TestTaskManagementService;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class TestTaskController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/test-task/index",
     *     tags={"TestTask"},
     *     summary="Get TestTasks",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="items", type="array", @OA\Items(ref="#/components/schemas/TestTask")),
     *              @OA\Property(property="_meta", type="object", ref="#/components/schemas/Meta"),
     *          )
     *     )
     * )
     */
    public function actionIndex(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => TestTask::find(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/test-task/view",
     *     tags={"TestTask"},
     *     summary="Get specific TestTask",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TestTask")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="TestTask id",
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
    public function actionView(string $id, _TestTaskRepository $TestTaskRepository): TestTask
    {
        return $TestTaskRepository->get($id);
    }

    /**
     * @OA\Post(
     *     path="/test-task/create",
     *     tags={"TestTask"},
     *     summary="Create TestTask",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TestTask")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TestTaskCreateForm"),
     *     )
     * )
     */
    public function actionCreate(TestTaskManagementService $TestTaskManagementService, _TestTaskRepository $TestTaskRepository): VacancyPublicationCreateForm | TestTask
    {
        $form = new VacancyPublicationCreateForm();
        $this->load($form);
        if ($filesData = null !== \Yii::$app->getRequest()->getBodyParam('files')) {
            $form->files = ArrayHelper::getColumn($form->files, function ($arrayData) {
                return new TestTaskFileCreateForm($arrayData);
            });
        }

        if ($form->validate()) {
            return $TestTaskManagementService->save($form);
        }

        return $form;
    }

    /**
     * @OA\Put(
     *     path="/test-task/update",
     *     tags={"TestTask"},
     *     summary="Update TestTask",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TestTaskUpdate")),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TestTaskUpdateForm")
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="TestTask id",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     )
     * )
     */
    public function actionUpdate(string $id, TestTaskManagementService $TestTaskManagementService, _TestTaskRepository $TestTaskRepository): TestTaskUpdateForm | TestTask
    {
        $model = $TestTaskRepository->get($id);
        $form = new TestTaskUpdateForm();
        $this->load($form);
        if (($filesData = \Yii::$app->getRequest()->getBodyParam('files')) !== null) {
            $form->files = ArrayHelper::getColumn($filesData, function ($arrayData) {
                return new TestTaskFileCreateForm($arrayData);
            });

            if ($form->validate()) {
                return $TestTaskManagementService->update($id, $form);
            }
        }

        return $form;
    }

    /**
     * @OA\Delete (
     *     path="/test-task/delete",
     *     tags={"TestTask"},
     *     summary="Delete Test Task",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="TestTask id",
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
    public function actionDelete(string $id, _TestTaskRepository $TestTaskRepository): EmptyResponse
    {
        $TestTaskRepository->delete($TestTaskRepository->get($id));

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
