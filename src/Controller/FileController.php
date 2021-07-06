<?php

declare(strict_types=1);

namespace App\Controller;

use App\Filesystem\FileStore;
use App\Filesystem\UrlGenerator;
use App\Form\UploadFile;
use League\Flysystem\FilesystemWriter;
use yii\web\UploadedFile;

class FileController extends BaseController
{
    protected function verbs(): array
    {
        return [
'upload' => ['POST'],
];
    }

    /**
     * @OA\Post(
     *     path="/file/upload",
     *     tags={"Files"},
     *     summary="Upload file to service",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\Property(property="file", type="string", format="binary")
     *     ),
     *     @OA\RequestBody(
     *         description="Requested body",
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(required={"file"}, @OA\Property(property="file", type="string", format="binary"))
     *       )
     *     )
     * )
     */
    public function actionUpload(UrlGenerator $urlGenerator, FilesystemWriter $fs): array
    {
        $form = new UploadFile();
        $form->file = UploadedFile::getInstanceByName('file');
        $fileStore = new FileStore($fs);
        $storeData = $fileStore->store($form->file);
        $storeData['link'] = $urlGenerator->getPublicUrl($storeData['path']);

        return $storeData;
    }
}
