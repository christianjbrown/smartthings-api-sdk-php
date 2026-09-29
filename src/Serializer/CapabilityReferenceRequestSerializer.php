<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationInterface;
use ChristianBrown\SmartThings\Model\CapabilityReferenceRequestInterface;
use ChristianBrown\SmartThings\Model\RestrictionInterface;

use function array_filter;

final class CapabilityReferenceRequestSerializer implements CapabilityReferenceRequestSerializerInterface
{
    private CapabilityConfigurationSerializerInterface $capabilityConfigurationSerializer;
    private RestrictionSerializerInterface $restrictionSerializer;

    public function __construct(CapabilityConfigurationSerializerInterface $capabilityConfigurationSerializer, RestrictionSerializerInterface $restrictionSerializer)
    {
        $this->capabilityConfigurationSerializer = $capabilityConfigurationSerializer;
        $this->restrictionSerializer = $restrictionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(CapabilityReferenceRequestInterface $model): array
    {
        $serialized = [
            self::KEY_ID => $model->getId(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_OPTIONAL => $model->getOptional(),
            self::KEY_CONFIG => $this->serializeOptionalConfig($model->getConfig()),
            self::KEY_RESTRICTIONS => $this->serializeOptionalRestrictions($model->getRestrictions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalConfig(?CapabilityConfigurationInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->capabilityConfigurationSerializer->serialize($value);
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
