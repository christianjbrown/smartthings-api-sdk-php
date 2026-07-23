<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ScheduleInterface;

interface ScheduleTransformerInterface
{
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ScheduleInterface;
}
