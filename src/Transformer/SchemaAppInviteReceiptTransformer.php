<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteReceipt;
use ChristianBrown\SmartThings\Model\SchemaAppInviteReceiptInterface;

use function is_string;

final class SchemaAppInviteReceiptTransformer implements SchemaAppInviteReceiptTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteReceiptInterface
    {
        $model = new SchemaAppInviteReceipt();

        self::applyInvitationId($model, $data);
        self::applyShortCode($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyInvitationId(SchemaAppInviteReceipt $model, array $data): void
    {
        if (empty($data[self::KEY_INVITATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_INVITATION_ID])) {
            return;
        }
        $model->setInvitationId($data[self::KEY_INVITATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShortCode(SchemaAppInviteReceipt $model, array $data): void
    {
        if (empty($data[self::KEY_SHORT_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_SHORT_CODE])) {
            return;
        }
        $model->setShortCode($data[self::KEY_SHORT_CODE]);
    }
}
