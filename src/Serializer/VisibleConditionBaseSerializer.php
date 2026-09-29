<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;

use function array_filter;

final class VisibleConditionBaseSerializer implements VisibleConditionBaseSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(VisibleConditionBaseInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_OPERAND => $model->getOperand(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
