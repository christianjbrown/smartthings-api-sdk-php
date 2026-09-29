<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceCapabilityDataAlertItemLastUpdateTimeInterface;

interface ServiceCapabilityDataAlertItemLastUpdateTimeTransformerInterface
{
    public const string KEY_VALUE = 'value';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceCapabilityDataAlertItemLastUpdateTimeInterface;
}
