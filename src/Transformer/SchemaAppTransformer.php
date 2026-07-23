<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaApp;
use ChristianBrown\SmartThings\Model\SchemaAppInterface;

use function is_string;
use function sprintf;

final class SchemaAppTransformer implements SchemaAppTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaAppInterface
    {
        if (empty($data[self::KEY_ENDPOINT_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ENDPOINT_APP_ID));
        }
        if (!is_string($data[self::KEY_ENDPOINT_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ENDPOINT_APP_ID));
        }
        $app = new SchemaApp($data[self::KEY_ENDPOINT_APP_ID]);

        self::applyAppName($app, $data);
        self::applyCertificationStatus($app, $data);
        self::applyPartnerName($app, $data);
        self::applyStClientId($app, $data);

        return $app;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppName(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_APP_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_NAME])) {
            return;
        }
        $app->setAppName($data[self::KEY_APP_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCertificationStatus(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_CERTIFICATION_STATUS])) {
            return;
        }
        if (!is_string($data[self::KEY_CERTIFICATION_STATUS])) {
            return;
        }
        $app->setCertificationStatus($data[self::KEY_CERTIFICATION_STATUS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPartnerName(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        $app->setPartnerName($data[self::KEY_PARTNER_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStClientId(SchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_ST_CLIENT_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ST_CLIENT_ID])) {
            return;
        }
        $app->setStClientId($data[self::KEY_ST_CLIENT_ID]);
    }
}
