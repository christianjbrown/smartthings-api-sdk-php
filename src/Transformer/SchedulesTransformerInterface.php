<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ScheduleInterface;

interface SchedulesTransformerInterface
{
    public const string ARRAY_NAME = 'schedule';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ScheduleInterface>
     */
    public function transform(array $data): array;
}
