<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInvite;
use ChristianBrown\SmartThings\Model\SchemaAppInviteInterface;

use function is_numeric;
use function is_string;

final class SchemaAppInviteTransformer implements SchemaAppInviteTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInviteInterface
    {
        $model = new SchemaAppInvite();

        self::applyId($model, $data);
        self::applySchemaAppId($model, $data);
        self::applyDescription($model, $data);
        self::applyExpiration($model, $data);
        self::applyAcceptUrl($model, $data);
        self::applyDeclineUrl($model, $data);
        self::applyShortCode($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAcceptUrl(SchemaAppInvite $model, array $data): void
    {
        if (empty($data[self::KEY_ACCEPT_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ACCEPT_URL])) {
            return;
        }
        $model->setAcceptUrl($data[self::KEY_ACCEPT_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeclineUrl(SchemaAppInvite $model, array $data): void
    {
        if (empty($data[self::KEY_DECLINE_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_DECLINE_URL])) {
            return;
        }
        $model->setDeclineUrl($data[self::KEY_DECLINE_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(SchemaAppInvite $model, array $data): void
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
    private static function applyExpiration(SchemaAppInvite $model, array $data): void
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
    private static function applyId(SchemaAppInvite $model, array $data): void
    {
        if (empty($data[self::KEY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ID])) {
            return;
        }
        $model->setId($data[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySchemaAppId(SchemaAppInvite $model, array $data): void
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
    private static function applyShortCode(SchemaAppInvite $model, array $data): void
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
