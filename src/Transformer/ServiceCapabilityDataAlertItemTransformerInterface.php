<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemInterface;

interface ServiceCapabilityDataAlertItemTransformerInterface
{
    public const string KEY_EXPIRE_TIME = 'expireTime';
    public const string KEY_HEADLINE_TEXT = 'headlineText';
    public const string KEY_ISSUE_TIME = 'issueTime';
    public const string KEY_LAST_UPDATE_TIME = 'lastUpdateTime';
    public const string KEY_MESSAGE_TYPE = 'messageType';
    public const string KEY_SEVERITY = 'severity';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataAlertItemInterface;
}
