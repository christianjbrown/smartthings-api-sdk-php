<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationAutomationInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceActionConfigEntryInterface;
use ChristianBrown\SmartThings\Model\ExcludedDeviceConditionConfigEntryInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationAutomationSerializer implements DeviceConfigurationAutomationSerializerInterface
{
    private DescriptionsInAutomationSerializerInterface $descriptionsInAutomationSerializer;
    private ExcludedDeviceActionConfigEntrySerializerInterface $excludedDeviceActionConfigEntrySerializer;
    private ExcludedDeviceConditionConfigEntrySerializerInterface $excludedDeviceConditionConfigEntrySerializer;

    public function __construct(ExcludedDeviceConditionConfigEntrySerializerInterface $excludedDeviceConditionConfigEntrySerializer, ExcludedDeviceActionConfigEntrySerializerInterface $excludedDeviceActionConfigEntrySerializer, DescriptionsInAutomationSerializerInterface $descriptionsInAutomationSerializer)
    {
        $this->excludedDeviceConditionConfigEntrySerializer = $excludedDeviceConditionConfigEntrySerializer;
        $this->excludedDeviceActionConfigEntrySerializer = $excludedDeviceActionConfigEntrySerializer;
        $this->descriptionsInAutomationSerializer = $descriptionsInAutomationSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationAutomationInterface $model): array
    {
        $serialized = [
            self::KEY_CONDITIONS => $this->serializeConditions($model->getConditions()),
            self::KEY_ACTIONS => $this->serializeActions($model->getActions()),
            self::KEY_DESCRIPTIONS => $this->serializeOptionalDescriptions($model->getDescriptions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, ExcludedDeviceActionConfigEntryInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeActions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (ExcludedDeviceActionConfigEntryInterface $item): array => $this->excludedDeviceActionConfigEntrySerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, ExcludedDeviceConditionConfigEntryInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (ExcludedDeviceConditionConfigEntryInterface $item): array => $this->excludedDeviceConditionConfigEntrySerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalDescriptions(?DescriptionsInAutomationInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->descriptionsInAutomationSerializer->serialize($value);
    }
}
