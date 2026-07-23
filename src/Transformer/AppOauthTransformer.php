<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppOauth;
use ChristianBrown\SmartThings\Model\AppOauthInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class AppOauthTransformer implements AppOauthTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppOauthInterface
    {
        $oauth = new AppOauth();

        self::applyClientName($oauth, $data);
        self::applyRedirectUris($oauth, $data);
        self::applyScope($oauth, $data);

        return $oauth;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyClientName(AppOauth $oauth, array $data): void
    {
        if (empty($data[self::KEY_CLIENT_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_CLIENT_NAME])) {
            return;
        }
        $oauth->setClientName($data[self::KEY_CLIENT_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRedirectUris(AppOauth $oauth, array $data): void
    {
        if (!isset($data[self::KEY_REDIRECT_URIS])) {
            return;
        }
        $oauth->setRedirectUris(self::extractStringList($data[self::KEY_REDIRECT_URIS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyScope(AppOauth $oauth, array $data): void
    {
        if (!isset($data[self::KEY_SCOPE])) {
            return;
        }
        $oauth->setScope(self::extractStringList($data[self::KEY_SCOPE]));
    }

    /**
     * @return array<int, string>
     */
    private static function extractStringList(mixed $value): array
    {
        if (!is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, static fn (mixed $item): bool => is_string($item)));
    }
}
