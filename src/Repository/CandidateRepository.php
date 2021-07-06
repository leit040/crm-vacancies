<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Candidate;

interface CandidateRepository
{
    public function get(string $id): Candidate;

    public function store(Candidate $candidate): void;

    public function delete(Candidate $candidate): void;
}
