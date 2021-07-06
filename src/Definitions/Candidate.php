<?php

declare(strict_types=1);

namespace App\Definitions;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="string"),
 *      @OA\Property(property="candidateStatus", type="string"),
 *     @OA\Property(property="fullName", type="string"),
 *      @OA\Property(property="position", type="string"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="socials", type="string"),
 *      @OA\Property(property="AssignToId", type="string"),
 *     @OA\Property(property="vacancyId", type="string"),
 *      @OA\Property(property="createdAt", type="string"),
 *      @OA\Property(property="IsResponded", type="string"),
 *     @OA\Property(property="files", type="array", @OA\Items(ref="#/components/schemas/CandidateFile")),
 * )
 */
final class Candidate
{
}
