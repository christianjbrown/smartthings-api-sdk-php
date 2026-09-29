<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemSeverity;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemSeverityInterface;

use function is_int;

final class ServiceCapabilityDataAlertItemSeverityTransformer implements ServiceCapabilityDataAlertItemSeverityTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataAlertItemSeverityInterface
    {
        $model = new ServiceCapabilityDataAlertItemSeverity();

        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(ServiceCapabilityDataAlertItemSeverity $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_int($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }
}
