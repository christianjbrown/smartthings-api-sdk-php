<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;
use ChristianBrown\SmartThings\Model\DeviceComponent;
use ChristianBrown\SmartThings\Model\DeviceComponentInterface;

use function array_map;
use function is_array;
use function sprintf;

final class DeviceComponentTransformer implements DeviceComponentTransformerInterface
{
    private DeviceCategoryTransformerInterface $deviceCategoryTransformer;
    private DeviceComponentCapabilitiesTransformerInterface $deviceComponentCapabilitiesTransformer;
    private RestrictionTransformerInterface $restrictionTransformer;
    private ValueReaderInterface $valueReader;

    public function __construct(DeviceComponentCapabilitiesTransformerInterface $deviceComponentCapabilitiesTransformer, ValueReaderInterface $valueReader, DeviceCategoryTransformerInterface $deviceCategoryTransformer, RestrictionTransformerInterface $restrictionTransformer)
    {
        $this->deviceComponentCapabilitiesTransformer = $deviceComponentCapabilitiesTransformer;
        $this->valueReader = $valueReader;
        $this->deviceCategoryTransformer = $deviceCategoryTransformer;
        $this->restrictionTransformer = $restrictionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceComponentInterface
    {
        $component = new DeviceComponent();

        if (empty($data[self::KEY_CAPABILITIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_CAPABILITIES));
        }
        if (!is_array($data[self::KEY_CAPABILITIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_CAPABILITIES));
        }
        $capabilities = $this->deviceComponentCapabilitiesTransformer->transform($data[self::KEY_CAPABILITIES]);
        $component->setCapabilities($capabilities);
        $this->applyDetails($component, $data);

        return $component;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDetails(DeviceComponentInterface $component, array $data): void
    {
        $restrictions = $this->valueReader->record($data, self::KEY_RESTRICTIONS);

        $component->setId($this->valueReader->string($data, self::KEY_ID));
        $component->setLabel($this->valueReader->string($data, self::KEY_LABEL));
        $component->setOptional($this->valueReader->bool($data, self::KEY_OPTIONAL));
        $component->setCategories(array_map(fn (array $item): DeviceCategoryInterface => $this->deviceCategoryTransformer->transform($item), $this->valueReader->records($data, self::KEY_CATEGORIES)));
        $component->setRestrictions(null === $restrictions ? null : $this->restrictionTransformer->transform($restrictions));
    }
}
