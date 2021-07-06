<?php

declare(strict_types=1);

namespace App\Definitions;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="string"),
 *     @OA\Property(property="position", type="string"),
 *     @OA\Property(property="briefId", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="files", type="array", @OA\Items(ref="#/components/schemas/TestTaskFile")),
 * )
 */
final class TestTask
{
}
