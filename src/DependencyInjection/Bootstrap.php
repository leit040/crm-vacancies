<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Filesystem\UrlGenerator;
use App\Repository\_TestTaskRepository;
use App\Repository\ARCandidateRepository;
use App\Repository\ARTestTaskRepository;
use App\Repository\ARVacancyRepository;
use App\Repository\CandidateRepository;
use App\Repository\VacancyRepository;
use App\UseCase\CandidateManagementService;
use App\UseCase\TestTaskManagementService;
use App\UseCase\VacancyManagementService;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemWriter;
use League\Flysystem\Local\LocalFilesystemAdapter;
use yii\base\BootstrapInterface;
use yii\web\UrlManager;

final class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton(Filesystem::class, function () {
            $adapter = new LocalFilesystemAdapter(\dirname(__DIR__) . '/../web/storage');

            return new Filesystem($adapter);
        });
        $container->setSingleton(FilesystemWriter::class, Filesystem::class);
        $container->setSingleton(UrlManager::class, $app->urlManager);
        $container->setSingleton(UrlGenerator::class, UrlGenerator::class);
        $container->setSingleton(CandidateRepository::class, ARCandidateRepository::class);
        $container->setSingleton(CandidateManagementService::class);
        $container->setSingleton(_TestTaskRepository::class, ARTestTaskRepository::class);
        $container->setSingleton(TestTaskManagementService::class);
        $container->setSingleton(VacancyRepository::class, ARVacancyRepository::class);
        $container->setSingleton(VacancyManagementService::class);
    }
}
