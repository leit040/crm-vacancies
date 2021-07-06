<?php

declare(strict_types=1);

namespace App\Model;

final class CandidateStatusType
{
    public const TYPE_BLACKLIST = 'blacklist';
    public const TYPE_ACTIVE = 'active';
    public const TYPE_ACCEPTED = 'accepted';
    public const TYPE_DECLINED = 'declined';
    public const TYPE_AWAITING = 'awaiting';
    public const TYPE_TEST_SENT = 'test_sent';

    public static function availableTypes(): array
    {
        return [
            self::TYPE_BLACKLIST,
            self::TYPE_ACTIVE,
            self::TYPE_ACCEPTED,
            self::TYPE_DECLINED,
            self::TYPE_AWAITING,
            self::TYPE_TEST_SENT,
        ];
    }
}
