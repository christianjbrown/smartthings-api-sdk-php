<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationActionExecutionResultInterface;

interface LocationActionExecutionResultTransformerInterface
{
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_MODE = 'mode';
    public const string KEY_RESULT = 'result';
    public const string KEY_SECURITY = 'security';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationActionExecutionResultInterface;
}
