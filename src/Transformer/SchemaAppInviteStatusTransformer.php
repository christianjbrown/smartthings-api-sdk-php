<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteStatus;
use ChristianBrown\SmartThings\Model\SchemaAppInviteStatusInterface;

use function is_bool;
use function is_numeric;
use function is_string;

final class SchemaAppInviteStatusTransformer implements SchemaAppInviteStatusTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteStatusInterface
    {
        $model = new SchemaAppInviteStatus();

        self::applySchemaAppId($model, $data);
        self::applyIsAccepted($model, $data);
        self::applyDescription($model, $data);
        self::applyExpiration($model, $data);
        self::applyShortCode($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(SchemaAppInviteStatus $model, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $model->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExpiration(SchemaAppInviteStatus $model, array $data): void
    {
        if (!isset($data[self::KEY_EXPIRATION])) {
            return;
        }
        if (!is_numeric($data[self::KEY_EXPIRATION])) {
            return;
        }
        $model->setExpiration((float) $data[self::KEY_EXPIRATION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIsAccepted(SchemaAppInviteStatus $model, array $data): void
    {
        if (!isset($data[self::KEY_IS_ACCEPTED])) {
            return;
        }
        if (!is_bool($data[self::KEY_IS_ACCEPTED])) {
            return;
        }
        $model->setIsAccepted($data[self::KEY_IS_ACCEPTED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySchemaAppId(SchemaAppInviteStatus $model, array $data): void
    {
        if (empty($data[self::KEY_SCHEMA_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_SCHEMA_APP_ID])) {
            return;
        }
        $model->setSchemaAppId($data[self::KEY_SCHEMA_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShortCode(SchemaAppInviteStatus $model, array $data): void
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
