<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\TestTask;

interface _TestTaskRepository
{
    public function get(string $id): TestTask;

    public function store(TestTask $testTask): void;

    public function delete(TestTask $testTask): void;
}
