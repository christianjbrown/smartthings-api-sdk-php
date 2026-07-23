<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceMeasurementInterface;

use function array_keys;
use function count;
use function is_array;
use function sprintf;

final class ServiceMeasurementsTransformer implements ServiceMeasurementsTransformerInterface
{
    private ServiceMeasurementTransformerInterface $serviceMeasurementTransformer;

    public function __construct(ServiceMeasurementTransformerInterface $serviceMeasurementTransformer)
    {
        $this->serviceMeasurementTransformer = $serviceMeasurementTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<string, ServiceMeasurementInterface>
     */
    public function transform(array $data): array
    {
        // The response keys each measurement by its field name (temperature,
        // relativeHumidity, ...), so the map keys are preserved in the result.
        $measurements = [];
        $names = array_keys($data);
        for ($i = 0, $count = count($names); $i < $count; ++$i) {
            $name = $names[$i];
            $measurementData = $data[$name];
            if (!is_array($measurementData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $measurements[(string) $name] = $this->serviceMeasurementTransformer->transform($measurementData);
        }

        return $measurements;
    }
}
