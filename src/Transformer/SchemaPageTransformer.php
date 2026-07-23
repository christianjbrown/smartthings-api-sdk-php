<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SchemaPage;
use ChristianBrown\SmartThings\Model\SchemaPageInterface;

use function is_string;
use function sprintf;

final class SchemaPageTransformer implements SchemaPageTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SchemaPageInterface
    {
        if (empty($data[self::KEY_PAGE_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PAGE_TYPE));
        }
        if (!is_string($data[self::KEY_PAGE_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PAGE_TYPE));
        }
        $page = new SchemaPage($data[self::KEY_PAGE_TYPE]);

        self::applyAppName($page, $data);
        self::applyIsaId($page, $data);
        self::applyLocationId($page, $data);
        self::applyOAuthLink($page, $data);
        self::applyPartnerName($page, $data);

        return $page;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppName(SchemaPage $page, array $data): void
    {
        if (empty($data[self::KEY_APP_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_NAME])) {
            return;
        }
        $page->setAppName($data[self::KEY_APP_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIsaId(SchemaPage $page, array $data): void
    {
        if (empty($data[self::KEY_ISA_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ISA_ID])) {
            return;
        }
        $page->setIsaId($data[self::KEY_ISA_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocationId(SchemaPage $page, array $data): void
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            return;
        }
        $page->setLocationId($data[self::KEY_LOCATION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOAuthLink(SchemaPage $page, array $data): void
    {
        if (empty($data[self::KEY_O_AUTH_LINK])) {
            return;
        }
        if (!is_string($data[self::KEY_O_AUTH_LINK])) {
            return;
        }
        $page->setOAuthLink($data[self::KEY_O_AUTH_LINK]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPartnerName(SchemaPage $page, array $data): void
    {
        if (empty($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_PARTNER_NAME])) {
            return;
        }
        $page->setPartnerName($data[self::KEY_PARTNER_NAME]);
    }
}
