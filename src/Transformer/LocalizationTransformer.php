<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Localization;
use ChristianBrown\SmartThings\Model\LocalizationInterface;

use function is_string;
use function sprintf;

final class LocalizationTransformer implements LocalizationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocalizationInterface
    {
        if (empty($data[self::KEY_TAG])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TAG));
        }
        if (!is_string($data[self::KEY_TAG])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TAG));
        }
        $localization = new Localization($data[self::KEY_TAG]);

        self::applyDescription($localization, $data);
        self::applyLabel($localization, $data);

        return $localization;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Localization $localization, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $localization->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(Localization $localization, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $localization->setLabel($data[self::KEY_LABEL]);
    }
}
