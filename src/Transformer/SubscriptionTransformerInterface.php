<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SubscriptionInterface;

interface SubscriptionTransformerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_INSTALLED_APP_ID = 'installedAppId';
    public const string KEY_SOURCE_TYPE = 'sourceType';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SubscriptionInterface;
}
