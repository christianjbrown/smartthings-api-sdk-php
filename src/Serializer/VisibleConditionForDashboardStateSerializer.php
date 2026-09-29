<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForDashboardStateInterface;

use function array_filter;

final class VisibleConditionForDashboardStateSerializer implements VisibleConditionForDashboardStateSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(VisibleConditionForDashboardStateInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_OPERAND => $model->getOperand(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_IS_OFFLINE => $model->getIsOffline(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
