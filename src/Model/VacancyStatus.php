<?php

declare(strict_types=1);

namespace App\Model;

final class VacancyStatus
{
    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_PAUSED = 'paused';

    public static function availableTypes(): array
    {
        return [
            self::STATUS_OPEN,
            self::STATUS_CLOSED,
            self::STATUS_PAUSED,
        ];
    }
}
