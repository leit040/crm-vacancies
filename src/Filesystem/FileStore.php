<?php

declare(strict_types=1);

namespace App\Filesystem;

use League\Flysystem\FilesystemWriter;
use yii\web\UploadedFile;

class FileStore
{
    public function __construct(FilesystemWriter $fs)
    {
        $this->fs = $fs;
    }

    private FilesystemWriter $fs;

    public function store(UploadedFile $file): array
    {
        $path = '/files/' . \Yii::$app->getSecurity()->generateRandomString(32) . '.' . $file->extension;

        $name = $file->getBaseName() . '.' . $file->extension;
        $fileStream = fopen($file->tempName, 'r+');
        $this->fs->writeStream($path, $fileStream, [
            'mimeType' => $file->type,
        ]);
        fclose($fileStream);

        return ['path' => $path, 'originalName' => $name];
    }
}
