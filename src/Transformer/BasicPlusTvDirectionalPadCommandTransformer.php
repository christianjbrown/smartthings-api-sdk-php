<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommand;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;

use function is_string;
use function sprintf;

final class BasicPlusTvDirectionalPadCommandTransformer implements BasicPlusTvDirectionalPadCommandTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvDirectionalPadCommandInterface
    {
        $model = new BasicPlusTvDirectionalPadCommand(self::requireUp($data), self::requireDown($data), self::requireLeft($data), self::requireRight($data), self::requireOk($data));

        self::applyName($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(BasicPlusTvDirectionalPadCommand $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDown(array $data): string
    {
        if (empty($data[self::KEY_DOWN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DOWN));
        }
        if (!is_string($data[self::KEY_DOWN])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DOWN));
        }

        return $data[self::KEY_DOWN];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLeft(array $data): string
    {
        if (empty($data[self::KEY_LEFT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LEFT));
        }
        if (!is_string($data[self::KEY_LEFT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LEFT));
        }

        return $data[self::KEY_LEFT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOk(array $data): string
    {
        if (empty($data[self::KEY_OK])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OK));
        }
        if (!is_string($data[self::KEY_OK])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OK));
        }

        return $data[self::KEY_OK];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireRight(array $data): string
    {
        if (empty($data[self::KEY_RIGHT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_RIGHT));
        }
        if (!is_string($data[self::KEY_RIGHT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_RIGHT));
        }

        return $data[self::KEY_RIGHT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireUp(array $data): string
    {
        if (empty($data[self::KEY_UP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_UP));
        }
        if (!is_string($data[self::KEY_UP])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_UP));
        }

        return $data[self::KEY_UP];
    }
}
