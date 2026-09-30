<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MessageConfigInterface;

interface MessageConfigTransformerInterface
{
    public const string KEY_MESSAGE_GROUP_KEY = 'messageGroupKey';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MessageConfigInterface;
}
