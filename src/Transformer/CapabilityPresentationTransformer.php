<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityPresentation;
use ChristianBrown\SmartThings\Model\CapabilityPresentationInterface;

use function is_int;
use function is_string;
use function sprintf;

final class CapabilityPresentationTransformer implements CapabilityPresentationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityPresentationInterface
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        $presentation = new CapabilityPresentation($data[self::KEY_ID]);

        self::applyVersion($presentation, $data);

        return $presentation;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(CapabilityPresentation $presentation, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $presentation->setVersion($data[self::KEY_VERSION]);
    }
}
