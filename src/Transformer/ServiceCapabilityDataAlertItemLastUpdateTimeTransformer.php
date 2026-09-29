<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemLastUpdateTime;
use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemLastUpdateTimeInterface;

use function is_string;

final class ServiceCapabilityDataAlertItemLastUpdateTimeTransformer implements ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataAlertItemLastUpdateTimeInterface
    {
        $model = new ServiceCapabilityDataAlertItemLastUpdateTime();

        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(ServiceCapabilityDataAlertItemLastUpdateTime $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }
}
