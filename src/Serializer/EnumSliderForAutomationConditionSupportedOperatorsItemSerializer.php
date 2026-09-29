<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;

final class EnumSliderForAutomationConditionSupportedOperatorsItemSerializer implements EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(EnumSliderForAutomationConditionSupportedOperatorsItemInterface $model): array
    {
        return [
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_LABEL => $model->getLabel(),
        ];
    }
}
