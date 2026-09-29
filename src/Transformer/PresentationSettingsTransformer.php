<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettings;
use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class PresentationSettingsTransformer implements PresentationSettingsTransformerInterface
{
    private PresentationSettingsTemperatureConversionsItemTransformerInterface $presentationSettingsTemperatureConversionsItemTransformer;

    public function __construct(PresentationSettingsTemperatureConversionsItemTransformerInterface $presentationSettingsTemperatureConversionsItemTransformer)
    {
        $this->presentationSettingsTemperatureConversionsItemTransformer = $presentationSettingsTemperatureConversionsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PresentationSettingsInterface
    {
        $model = new PresentationSettings();

        $this->applyTemperatureConversions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTemperatureConversions(PresentationSettings $model, array $data): void
    {
        if (!isset($data[self::KEY_TEMPERATURE_CONVERSIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_TEMPERATURE_CONVERSIONS])) {
            return;
        }
        $model->setTemperatureConversions($this->transformListPresentationSettingsTemperatureConversionsItem($data[self::KEY_TEMPERATURE_CONVERSIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PresentationSettingsTemperatureConversionsItemInterface>
     */
    private function transformListPresentationSettingsTemperatureConversionsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): PresentationSettingsTemperatureConversionsItemInterface => $this->presentationSettingsTemperatureConversionsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
