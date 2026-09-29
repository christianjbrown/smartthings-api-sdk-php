<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityReferenceRequestInterface;
use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileComponentRequestInterface;
use ChristianBrown\SmartThings\Model\RestrictionInterface;

use function array_filter;
use function array_map;

final class DeviceProfileComponentRequestSerializer implements DeviceProfileComponentRequestSerializerInterface
{
    private CapabilityReferenceRequestSerializerInterface $capabilityReferenceRequestSerializer;
    private DeviceCategorySerializerInterface $deviceCategorySerializer;
    private RestrictionSerializerInterface $restrictionSerializer;

    public function __construct(CapabilityReferenceRequestSerializerInterface $capabilityReferenceRequestSerializer, DeviceCategorySerializerInterface $deviceCategorySerializer, RestrictionSerializerInterface $restrictionSerializer)
    {
        $this->capabilityReferenceRequestSerializer = $capabilityReferenceRequestSerializer;
        $this->deviceCategorySerializer = $deviceCategorySerializer;
        $this->restrictionSerializer = $restrictionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceProfileComponentRequestInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_ID => $model->getId(),
            self::KEY_CAPABILITIES => $this->serializeCapabilities($model->getCapabilities()),
            self::KEY_CATEGORIES => $this->serializeCategories($model->getCategories()),
            self::KEY_RESTRICTIONS => $this->serializeOptionalRestrictions($model->getRestrictions()),
            self::KEY_OPTIONAL => $model->getOptional(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, CapabilityReferenceRequestInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeCapabilities(array $values): array
    {
        return array_map(fn (CapabilityReferenceRequestInterface $item): array => $this->capabilityReferenceRequestSerializer->serialize($item), $values);
    }

    /**
     * @param array<int, DeviceCategoryInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeCategories(array $values): array
    {
        return array_map(fn (DeviceCategoryInterface $item): array => $this->deviceCategorySerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalRestrictions(?RestrictionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->restrictionSerializer->serialize($value);
    }
}
