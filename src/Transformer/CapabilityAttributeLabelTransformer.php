<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLabel;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLabelInterface;

use function is_string;
use function sprintf;

final class CapabilityAttributeLabelTransformer implements CapabilityAttributeLabelTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityAttributeLabelInterface
    {
        $model = new CapabilityAttributeLabel(self::requireLabel($data));

        self::applyDescription($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(CapabilityAttributeLabel $model, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $model->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLabel(array $data): string
    {
        if (empty($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }
        if (!is_string($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }

        return $data[self::KEY_LABEL];
    }
}
