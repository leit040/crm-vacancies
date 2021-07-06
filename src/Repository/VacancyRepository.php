<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Vacancy;

interface VacancyRepository
{
    public function get(string $id): Vacancy;

    public function store(Vacancy $vacancy): void;

    public function delete(Vacancy $vacancy): void;
}
