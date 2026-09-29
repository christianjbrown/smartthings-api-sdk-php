<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\GroupVisibleConditionsInterface;

use function array_filter;

final class GroupVisibleConditionsSerializer implements GroupVisibleConditionsSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(GroupVisibleConditionsInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_OPERAND => $model->getOperand(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
