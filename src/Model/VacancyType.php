<?php

declare(strict_types=1);

namespace App\Model;

final class VacancyType
{
    public const TYPE_FULL_TIME = 'fullTime';
    public const TYPE_PART_TIME = 'partTime';
    public const TYPE_TEMPORARY = 'temporary';

    public static function availableTypes(): array
    {
        return [
            self::TYPE_FULL_TIME,
            self::TYPE_PART_TIME,
            self::TYPE_TEMPORARY,
        ];
    }
}
