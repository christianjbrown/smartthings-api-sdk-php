<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppInterface;

interface AppTransformerInterface
{
    public const string KEY_APP_ID = 'appId';
    public const string KEY_APP_NAME = 'appName';
    public const string KEY_APP_TYPE = 'appType';
    public const string KEY_DISPLAY_NAME = 'displayName';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppInterface;
}
