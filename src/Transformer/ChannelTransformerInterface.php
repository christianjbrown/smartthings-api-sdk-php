<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ChannelInterface;

interface ChannelTransformerInterface
{
    public const string KEY_CHANNEL_ID = 'channelId';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_NAME = 'name';
    public const string KEY_TERMS_OF_SERVICE_URL = 'termsOfServiceUrl';
    public const string KEY_TYPE = 'type';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ChannelInterface;
}
