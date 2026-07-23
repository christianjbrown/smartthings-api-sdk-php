<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DevicePreferenceDefinitionInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class DevicePreferenceDefinitionsTransformer implements DevicePreferenceDefinitionsTransformerInterface
{
    private DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer;

    public function __construct(DevicePreferenceDefinitionTransformerInterface $devicePreferenceDefinitionTransformer)
    {
        $this->devicePreferenceDefinitionTransformer = $devicePreferenceDefinitionTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DevicePreferenceDefinitionInterface>
     */
    public function transform(array $data): array
    {
        $definitions = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $definitionData = $values[$i];
            if (!is_array($definitionData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $definitions[] = $this->devicePreferenceDefinitionTransformer->transform($definitionData);
        }

        return $definitions;
    }
}
