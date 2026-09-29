<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\WebhookSmartAppInterface;

interface WebhookSmartAppTransformerInterface
{
    public const string KEY_PUBLIC_KEY = 'publicKey';
    public const string KEY_SIGNATURE_TYPE = 'signatureType';
    public const string KEY_TARGET_STATUS = 'targetStatus';
    public const string KEY_TARGET_URL = 'targetUrl';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): WebhookSmartAppInterface;
}
