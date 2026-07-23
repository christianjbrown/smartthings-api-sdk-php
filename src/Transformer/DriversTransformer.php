<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DriverInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class DriversTransformer implements DriversTransformerInterface
{
    private DriverTransformerInterface $driverTransformer;

    public function __construct(DriverTransformerInterface $driverTransformer)
    {
        $this->driverTransformer = $driverTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DriverInterface>
     */
    public function transform(array $data): array
    {
        $drivers = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $driverData = $values[$i];
            if (!is_array($driverData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $drivers[] = $this->driverTransformer->transform($driverData);
        }

        return $drivers;
    }
}
