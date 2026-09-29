<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettingsForDevicePresentation;
use ChristianBrown\SmartThings\Model\PresentationSettingsForDevicePresentationInterface;
use ChristianBrown\SmartThings\Model\TemperatureConversionsItemForDevicePresentationInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class PresentationSettingsForDevicePresentationTransformer implements PresentationSettingsForDevicePresentationTransformerInterface
{
    private TemperatureConversionsItemForDevicePresentationTransformerInterface $temperatureConversionsItemForDevicePresentationTransformer;

    public function __construct(TemperatureConversionsItemForDevicePresentationTransformerInterface $temperatureConversionsItemForDevicePresentationTransformer)
    {
        $this->temperatureConversionsItemForDevicePresentationTransformer = $temperatureConversionsItemForDevicePresentationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PresentationSettingsForDevicePresentationInterface
    {
        $model = new PresentationSettingsForDevicePresentation();

        $this->applyTemperatureConversions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTemperatureConversions(PresentationSettingsForDevicePresentation $model, array $data): void
    {
        if (!isset($data[self::KEY_TEMPERATURE_CONVERSIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_TEMPERATURE_CONVERSIONS])) {
            return;
        }
        $model->setTemperatureConversions($this->transformListTemperatureConversionsItemForDevicePresentation($data[self::KEY_TEMPERATURE_CONVERSIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TemperatureConversionsItemForDevicePresentationInterface>
     */
    private function transformListTemperatureConversionsItemForDevicePresentation(array $data): array
    {
        return array_values(array_map(fn (array $item): TemperatureConversionsItemForDevicePresentationInterface => $this->temperatureConversionsItemForDevicePresentationTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
