<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalizationInterface;
use ChristianBrown\SmartThings\Model\LocalizationDetails;
use ChristianBrown\SmartThings\Model\LocalizationDetailsInterface;
use ChristianBrown\SmartThings\Model\PreferenceOptionLocalizationInterface;

use function array_filter;
use function array_map;
use function is_array;

final class LocalizationDetailsTransformer implements LocalizationDetailsTransformerInterface
{
    private CapabilityAttributeLocalizationTransformerInterface $capabilityAttributeLocalizationTransformer;
    private CapabilityCommandLocalizationTransformerInterface $capabilityCommandLocalizationTransformer;
    private PreferenceOptionLocalizationTransformerInterface $preferenceOptionLocalizationTransformer;

    public function __construct(PreferenceOptionLocalizationTransformerInterface $preferenceOptionLocalizationTransformer, CapabilityAttributeLocalizationTransformerInterface $capabilityAttributeLocalizationTransformer, CapabilityCommandLocalizationTransformerInterface $capabilityCommandLocalizationTransformer)
    {
        $this->preferenceOptionLocalizationTransformer = $preferenceOptionLocalizationTransformer;
        $this->capabilityAttributeLocalizationTransformer = $capabilityAttributeLocalizationTransformer;
        $this->capabilityCommandLocalizationTransformer = $capabilityCommandLocalizationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocalizationDetailsInterface
    {
        $model = new LocalizationDetails();

        $this->applyOptions($model, $data);
        $this->applyAttributes($model, $data);
        $this->applyCommands($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAttributes(LocalizationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ATTRIBUTES])) {
            return;
        }
        if (!is_array($data[self::KEY_ATTRIBUTES])) {
            return;
        }
        $model->setAttributes($this->transformMapCapabilityAttributeLocalization($data[self::KEY_ATTRIBUTES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCommands(LocalizationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_COMMANDS])) {
            return;
        }
        if (!is_array($data[self::KEY_COMMANDS])) {
            return;
        }
        $model->setCommands($this->transformMapCapabilityCommandLocalization($data[self::KEY_COMMANDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOptions(LocalizationDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_OPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_OPTIONS])) {
            return;
        }
        $model->setOptions($this->transformMapPreferenceOptionLocalization($data[self::KEY_OPTIONS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, CapabilityAttributeLocalizationInterface>
     */
    private function transformMapCapabilityAttributeLocalization(array $data): array
    {
        return array_map(fn (array $item): CapabilityAttributeLocalizationInterface => $this->capabilityAttributeLocalizationTransformer->transform($item), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, CapabilityCommandLocalizationInterface>
     */
    private function transformMapCapabilityCommandLocalization(array $data): array
    {
        return array_map(fn (array $item): CapabilityCommandLocalizationInterface => $this->capabilityCommandLocalizationTransformer->transform($item), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, PreferenceOptionLocalizationInterface>
     */
    private function transformMapPreferenceOptionLocalization(array $data): array
    {
        return array_map(fn (array $item): PreferenceOptionLocalizationInterface => $this->preferenceOptionLocalizationTransformer->transform($item), array_filter($data, is_array(...)));
    }
}
