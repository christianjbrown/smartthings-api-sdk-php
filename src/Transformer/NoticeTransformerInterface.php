<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\NoticeInterface;

interface NoticeTransformerInterface
{
    public const string KEY_ACTIONS = 'actions';
    public const string KEY_BADGE_URL = 'badgeUrl';
    public const string KEY_CODE = 'code';
    public const string KEY_MESSAGE = 'message';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): NoticeInterface;
}
