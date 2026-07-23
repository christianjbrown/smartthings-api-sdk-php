<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Presentation;
use ChristianBrown\SmartThings\Model\PresentationInterface;

use function is_string;
use function sprintf;

final class PresentationTransformer implements PresentationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PresentationInterface
    {
        if (empty($data[self::KEY_PRESENTATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PRESENTATION_ID));
        }
        if (!is_string($data[self::KEY_PRESENTATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PRESENTATION_ID));
        }
        $presentation = new Presentation($data[self::KEY_PRESENTATION_ID]);

        self::applyManufacturerName($presentation, $data);
        self::applyType($presentation, $data);

        return $presentation;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyManufacturerName(Presentation $presentation, array $data): void
    {
        if (empty($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_MANUFACTURER_NAME])) {
            return;
        }
        $presentation->setManufacturerName($data[self::KEY_MANUFACTURER_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(Presentation $presentation, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $presentation->setType($data[self::KEY_TYPE]);
    }
}
