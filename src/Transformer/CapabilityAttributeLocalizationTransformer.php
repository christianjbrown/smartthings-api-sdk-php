<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityAttributeLabelInterface;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalization;
use ChristianBrown\SmartThings\Model\CapabilityAttributeLocalizationInterface;

use function array_filter;
use function array_map;
use function is_array;
use function is_string;

final class CapabilityAttributeLocalizationTransformer implements CapabilityAttributeLocalizationTransformerInterface
{
    private CapabilityAttributeLabelTransformerInterface $capabilityAttributeLabelTransformer;

    public function __construct(CapabilityAttributeLabelTransformerInterface $capabilityAttributeLabelTransformer)
    {
        $this->capabilityAttributeLabelTransformer = $capabilityAttributeLabelTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityAttributeLocalizationInterface
    {
        $model = new CapabilityAttributeLocalization();

        self::applyLabel($model, $data);
        self::applyDescription($model, $data);
        self::applyDisplayTemplate($model, $data);
        $this->applyI18n($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(CapabilityAttributeLocalization $model, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $model->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDisplayTemplate(CapabilityAttributeLocalization $model, array $data): void
    {
        if (empty($data[self::KEY_DISPLAY_TEMPLATE])) {
            return;
        }
        if (!is_string($data[self::KEY_DISPLAY_TEMPLATE])) {
            return;
        }
        $model->setDisplayTemplate($data[self::KEY_DISPLAY_TEMPLATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyI18n(CapabilityAttributeLocalization $model, array $data): void
    {
        if (!isset($data[self::KEY_I18N])) {
            return;
        }
        if (!is_array($data[self::KEY_I18N])) {
            return;
        }
        $model->setI18n($this->transformMapMapCapabilityAttributeLabel($data[self::KEY_I18N]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(CapabilityAttributeLocalization $model, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $model->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, array<array-key, CapabilityAttributeLabelInterface>>
     */
    private function transformMapMapCapabilityAttributeLabel(array $data): array
    {
        return array_map(fn (array $inner): array => array_map(fn (array $item): CapabilityAttributeLabelInterface => $this->capabilityAttributeLabelTransformer->transform($item), array_filter($inner, is_array(...))), array_filter($data, is_array(...)));
    }
}
