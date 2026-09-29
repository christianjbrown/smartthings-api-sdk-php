<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationInterface;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;

use function array_map;

final class CapabilityConfigurationSerializer implements CapabilityConfigurationSerializerInterface
{
    private CapabilityConfigurationValueSerializerInterface $capabilityConfigurationValueSerializer;

    public function __construct(CapabilityConfigurationValueSerializerInterface $capabilityConfigurationValueSerializer)
    {
        $this->capabilityConfigurationValueSerializer = $capabilityConfigurationValueSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityConfigurationInterface $model): array
    {
        return [
            self::KEY_VALUES => $this->serializeValues($model->getValues()),
        ];
    }

    /**
     * @param array<int, CapabilityConfigurationValueInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeValues(array $values): array
    {
        return array_map(fn (CapabilityConfigurationValueInterface $item): array => $this->capabilityConfigurationValueSerializer->serialize($item), $values);
    }
}
