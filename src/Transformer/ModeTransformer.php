<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Mode;
use ChristianBrown\SmartThings\Model\ModeInterface;

use function is_string;
use function sprintf;

final class ModeTransformer implements ModeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ModeInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $mode = new Mode($data[self::KEY_ID]);

        self::applyLabel($mode, $data);
        self::applyName($mode, $data);

        return $mode;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(Mode $mode, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $mode->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(Mode $mode, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $mode->setName($data[self::KEY_NAME]);
    }
}
