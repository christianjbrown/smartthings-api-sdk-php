<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppReceipt;
use ChristianBrown\SmartThings\Model\SchemaAppReceiptInterface;

use function is_string;

final class SchemaAppReceiptTransformer implements SchemaAppReceiptTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppReceiptInterface
    {
        $model = new SchemaAppReceipt();

        self::applyEndpointAppId($model, $data);
        self::applyStClientId($model, $data);
        self::applyStClientSecret($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEndpointAppId(SchemaAppReceipt $model, array $data): void
    {
        if (empty($data[self::KEY_ENDPOINT_APP_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ENDPOINT_APP_ID])) {
            return;
        }
        $model->setEndpointAppId($data[self::KEY_ENDPOINT_APP_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStClientId(SchemaAppReceipt $model, array $data): void
    {
        if (empty($data[self::KEY_ST_CLIENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ST_CLIENT_ID])) {
            return;
        }
        $model->setStClientId($data[self::KEY_ST_CLIENT_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStClientSecret(SchemaAppReceipt $model, array $data): void
    {
        if (empty($data[self::KEY_ST_CLIENT_SECRET])) {
            return;
        }
        if (!is_string($data[self::KEY_ST_CLIENT_SECRET])) {
            return;
        }
        $model->setStClientSecret($data[self::KEY_ST_CLIENT_SECRET]);
    }
}
