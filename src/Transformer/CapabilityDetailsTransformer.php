<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandInterface;
use ChristianBrown\SmartThings\Model\CapabilityDetails;
use ChristianBrown\SmartThings\Model\CapabilityDetailsInterface;

use function array_filter;
use function array_map;
use function is_array;

final class CapabilityDetailsTransformer implements CapabilityDetailsTransformerInterface
{
    private CapabilityAttributeTransformerInterface $capabilityAttributeTransformer;
    private CapabilityCommandTransformerInterface $capabilityCommandTransformer;

    public function __construct(CapabilityAttributeTransformerInterface $capabilityAttributeTransformer, CapabilityCommandTransformerInterface $capabilityCommandTransformer)
    {
        $this->capabilityAttributeTransformer = $capabilityAttributeTransformer;
        $this->capabilityCommandTransformer = $capabilityCommandTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityDetailsInterface
    {
        $model = new CapabilityDetails();

        $this->applyAttributes($model, $data);
        $this->applyCommands($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAttributes(CapabilityDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ATTRIBUTES])) {
            return;
        }
        if (!is_array($data[self::KEY_ATTRIBUTES])) {
            return;
        }
        $model->setAttributes($this->transformMapCapabilityAttribute($data[self::KEY_ATTRIBUTES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCommands(CapabilityDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_COMMANDS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMANDS])) {
            return;
        }
        $model->setCommands($this->transformMapCapabilityCommand($data[self::KEY_COMMANDS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, CapabilityAttributeInterface>
     */
    private function transformMapCapabilityAttribute(array $data): array
    {
        return array_map(fn (array $item): CapabilityAttributeInterface => $this->capabilityAttributeTransformer->transform($item), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, CapabilityCommandInterface>
     */
    private function transformMapCapabilityCommand(array $data): array
    {
        return array_map(fn (array $item): CapabilityCommandInterface => $this->capabilityCommandTransformer->transform($item), array_filter($data, is_array(...)));
    }
}
