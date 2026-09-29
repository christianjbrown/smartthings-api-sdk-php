<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SliderForLightInterface;

use function array_filter;

final class SliderForLightSerializer implements SliderForLightSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(SliderForLightInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_STEP => $model->getStep(),
            self::KEY_UNIT => $model->getUnit(),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
            self::KEY_LABEL => $model->getLabel(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
