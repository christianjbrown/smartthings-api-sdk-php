<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceProfileInterface;

use function array_values;
use function count;
use function sprintf;

final class DeviceProfilesTransformer implements DeviceProfilesTransformerInterface
{
    private DeviceProfileTransformerInterface $deviceProfileTransformer;

    public function __construct(DeviceProfileTransformerInterface $deviceProfileTransformer)
    {
        $this->deviceProfileTransformer = $deviceProfileTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceProfileInterface>
     */
    public function transform(array $data): array
    {
        $profiles = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $profileData = $values[$i];
            if (!is_array($profileData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $profiles[] = $this->deviceProfileTransformer->transform($profileData);
        }

        return $profiles;
    }
}
