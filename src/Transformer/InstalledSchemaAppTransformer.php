<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\InstalledSchemaApp;
use ChristianBrown\SmartThings\Model\InstalledSchemaAppInterface;

use function is_string;
use function sprintf;

final class InstalledSchemaAppTransformer implements InstalledSchemaAppTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledSchemaAppInterface
    {
        if (empty($data[self::KEY_ISA_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ISA_ID));
        }
        if (!is_string($data[self::KEY_ISA_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ISA_ID));
        }
        $app = new InstalledSchemaApp($data[self::KEY_ISA_ID]);

        self::applyAppName($app, $data);
        self::applyLocationId($app, $data);
        self::applyOAuthLink($app, $data);
        self::applyPageType($app, $data);
        self::applyPartnerName($app, $data);

        return $app;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppName(InstalledSchemaApp $app, array $data): void
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
    private static function applyLocationId(InstalledSchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $app->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOAuthLink(InstalledSchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_O_AUTH_LINK])) {
            return;
        }
        if (!is_string($data[self::KEY_O_AUTH_LINK])) {
            return;
        }
        $app->setOAuthLink($data[self::KEY_O_AUTH_LINK]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPageType(InstalledSchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_PAGE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_PAGE_TYPE])) {
            return;
        }
        $app->setPageType($data[self::KEY_PAGE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPartnerName(InstalledSchemaApp $app, array $data): void
    {
        if (empty($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        $app->setPartnerName($data[self::KEY_PARTNER_NAME]);
    }
}
