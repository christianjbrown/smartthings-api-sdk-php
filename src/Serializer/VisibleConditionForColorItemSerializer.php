<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferToInterface;

use function array_filter;

final class VisibleConditionForColorItemSerializer implements VisibleConditionForColorItemSerializerInterface
{
    private VisibleConditionForColorItemReferToSerializerInterface $visibleConditionForColorItemReferToSerializer;

    public function __construct(VisibleConditionForColorItemReferToSerializerInterface $visibleConditionForColorItemReferToSerializer)
    {
        $this->visibleConditionForColorItemReferToSerializer = $visibleConditionForColorItemReferToSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(VisibleConditionForColorItemInterface $model): array
    {
        $serialized = [
            self::KEY_REFER_TO => $this->serializeOptionalReferTo($model->getReferTo()),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_OPERAND => $model->getOperand(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalReferTo(?VisibleConditionForColorItemReferToInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionForColorItemReferToSerializer->serialize($value);
    }
}
