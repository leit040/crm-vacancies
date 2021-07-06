<?php

declare(strict_types=1);

namespace App\Definitions;

/**
 * @OA\Schema(
 *      @OA\Property(property="id", type="string"),
 *      @OA\Property(property="name", type="string"),
 *     @OA\Property(property="rate", type="string"),
 *      @OA\Property(property="position", type="string"),
 *     @OA\Property(property="count", type="integer"),
 *     @OA\Property(property="VacancyStatus", type="string"),
 *      @OA\Property(property="AssignTo", type="string"),
 *     @OA\Property(property="vacancyType", type="string"),
 *      @OA\Property(property="IsRemote", type="boolean"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="files", type="array", @OA\Items(ref="#/components/schemas/VacancyFile")),
 *     @OA\Property(property="publications", type="array", @OA\Items(ref="#/components/schemas/VacancyPublication")),
 * )
 */
final class VacancyUpdate
{
}
