<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentI18nInterface;
use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalization;
use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalizationInterface;

use function array_filter;
use function array_map;
use function is_array;
use function is_string;

final class CapabilityArgumentLocalizationTransformer implements CapabilityArgumentLocalizationTransformerInterface
{
    private CapabilityArgumentI18nTransformerInterface $capabilityArgumentI18nTransformer;

    public function __construct(CapabilityArgumentI18nTransformerInterface $capabilityArgumentI18nTransformer)
    {
        $this->capabilityArgumentI18nTransformer = $capabilityArgumentI18nTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityArgumentLocalizationInterface
    {
        $model = new CapabilityArgumentLocalization();

        $this->applyI18n($model, $data);
        self::applyLabel($model, $data);
        self::applyDescription($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(CapabilityArgumentLocalization $model, array $data): void
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
    private function applyI18n(CapabilityArgumentLocalization $model, array $data): void
    {
        if (!isset($data[self::KEY_I18N])) {
            return;
        }
        if (!is_array($data[self::KEY_I18N])) {
            return;
        }
        $model->setI18n($this->transformMapCapabilityArgumentI18n($data[self::KEY_I18N]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(CapabilityArgumentLocalization $model, array $data): void
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
     * @return array<array-key, CapabilityArgumentI18nInterface>
     */
    private function transformMapCapabilityArgumentI18n(array $data): array
    {
        return array_map(fn (array $item): CapabilityArgumentI18nInterface => $this->capabilityArgumentI18nTransformer->transform($item), array_filter($data, is_array(...)));
    }
}
