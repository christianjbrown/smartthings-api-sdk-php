<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceMeasurementInterface;

interface ServiceMeasurementTransformerInterface
{
    public const string KEY_UNIT = 'unit';
    public const string KEY_VALUE = 'value';
    public const string UNEXPECTED_VALUE = 'value not set or not a scalar';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceMeasurementInterface;
}
