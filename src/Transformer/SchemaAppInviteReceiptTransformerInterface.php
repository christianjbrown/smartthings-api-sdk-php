<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteReceiptInterface;

interface SchemaAppInviteReceiptTransformerInterface
{
    public const string KEY_INVITATION_ID = 'invitationId';
    public const string KEY_SHORT_CODE = 'shortCode';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteReceiptInterface;
}
