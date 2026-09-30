<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ComponentStatusInterface;
use ChristianBrown\SmartThings\Model\DeviceStatusReport;
use ChristianBrown\SmartThings\Model\DeviceStatusReportInterface;

use function array_filter;
use function array_map;
use function is_array;

final class DeviceStatusReportTransformer implements DeviceStatusReportTransformerInterface
{
    private ComponentStatusTransformerInterface $componentStatusTransformer;
    private IdLessHealthStateTransformerInterface $idLessHealthStateTransformer;
    private ValueReaderInterface $valueReader;

    public function __construct(ComponentStatusTransformerInterface $componentStatusTransformer, IdLessHealthStateTransformerInterface $idLessHealthStateTransformer, ValueReaderInterface $valueReader)
    {
        $this->componentStatusTransformer = $componentStatusTransformer;
        $this->idLessHealthStateTransformer = $idLessHealthStateTransformer;
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceStatusReportInterface
    {
        $components = $this->valueReader->record($data, self::KEY_COMPONENTS) ?? [];
        $healthState = $this->valueReader->record($data, self::KEY_HEALTH_STATE);

        return (new DeviceStatusReport())
            ->setComponents(
                array_map(
                    fn (array $capabilities): ComponentStatusInterface => $this->componentStatusTransformer->transform($capabilities),
                    array_filter($components, is_array(...))
                )
            )
            ->setHealthState(null === $healthState ? null : $this->idLessHealthStateTransformer->transform($healthState));
    }
}
