<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityConfiguration;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationInterface;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function sprintf;

final class CapabilityConfigurationTransformer implements CapabilityConfigurationTransformerInterface
{
    private CapabilityConfigurationValueTransformerInterface $capabilityConfigurationValueTransformer;

    public function __construct(CapabilityConfigurationValueTransformerInterface $capabilityConfigurationValueTransformer)
    {
        $this->capabilityConfigurationValueTransformer = $capabilityConfigurationValueTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityConfigurationInterface
    {
        $model = new CapabilityConfiguration($this->requireValues($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityConfigurationValueInterface>
     */
    private function requireValues(array $data): array
    {
        if (!isset($data[self::KEY_VALUES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_VALUES));
        }
        if (!is_array($data[self::KEY_VALUES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_VALUES));
        }

        return $this->transformListCapabilityConfigurationValue($data[self::KEY_VALUES]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, CapabilityConfigurationValueInterface>
     */
    private function transformListCapabilityConfigurationValue(array $data): array
    {
        return array_values(array_map(fn (array $item): CapabilityConfigurationValueInterface => $this->capabilityConfigurationValueTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
