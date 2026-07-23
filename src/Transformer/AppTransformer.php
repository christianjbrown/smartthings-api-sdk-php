<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\App;
use ChristianBrown\SmartThings\Model\AppInterface;

use function is_string;
use function sprintf;

final class AppTransformer implements AppTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppInterface
    {
        if (empty($data[self::KEY_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_APP_ID));
        }
        if (!is_string($data[self::KEY_APP_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_APP_ID));
        }
        $app = new App($data[self::KEY_APP_ID]);

        self::applyAppName($app, $data);
        self::applyAppType($app, $data);
        self::applyDisplayName($app, $data);

        return $app;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAppName(App $app, array $data): void
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
    private static function applyAppType(App $app, array $data): void
    {
        if (empty($data[self::KEY_APP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_APP_TYPE])) {
            return;
        }
        $app->setAppType($data[self::KEY_APP_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDisplayName(App $app, array $data): void
    {
        if (empty($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_DISPLAY_NAME])) {
            return;
        }
        $app->setDisplayName($data[self::KEY_DISPLAY_NAME]);
    }
}
