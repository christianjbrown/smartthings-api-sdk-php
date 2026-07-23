<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ServiceMeasurementInterface;

interface ServiceMeasurementsTransformerInterface
{
    public const string ARRAY_NAME = 'measurement';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<string, ServiceMeasurementInterface>
     */
    public function transform(array $data): array;
}
