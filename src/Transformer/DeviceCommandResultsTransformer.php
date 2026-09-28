<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;

use function array_values;
use function count;
use function sprintf;

final class DeviceCommandResultsTransformer implements DeviceCommandResultsTransformerInterface
{
    private DeviceCommandResultTransformerInterface $deviceCommandResultTransformer;

    public function __construct(DeviceCommandResultTransformerInterface $deviceCommandResultTransformer)
    {
        $this->deviceCommandResultTransformer = $deviceCommandResultTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceCommandResultInterface>
     */
    public function transform(array $data): array
    {
        $results = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $resultData = $values[$i];
            if (!is_array($resultData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $results[] = $this->deviceCommandResultTransformer->transform($resultData);
        }

        return $results;
    }
}
