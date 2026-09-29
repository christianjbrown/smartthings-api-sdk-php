<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentLocalizationInterface;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalization;
use ChristianBrown\SmartThings\Model\CapabilityCommandLocalizationInterface;

use function array_filter;
use function array_map;
use function is_array;
use function is_string;

final class CapabilityCommandLocalizationTransformer implements CapabilityCommandLocalizationTransformerInterface
{
    private CapabilityArgumentLocalizationTransformerInterface $capabilityArgumentLocalizationTransformer;

    public function __construct(CapabilityArgumentLocalizationTransformerInterface $capabilityArgumentLocalizationTransformer)
    {
        $this->capabilityArgumentLocalizationTransformer = $capabilityArgumentLocalizationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityCommandLocalizationInterface
    {
        $model = new CapabilityCommandLocalization();

        self::applyLabel($model, $data);
        self::applyDescription($model, $data);
        $this->applyArguments($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyArguments(CapabilityCommandLocalization $model, array $data): void
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return;
        }
        $model->setArguments($this->transformMapCapabilityArgumentLocalization($data[self::KEY_ARGUMENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(CapabilityCommandLocalization $model, array $data): void
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
    private static function applyLabel(CapabilityCommandLocalization $model, array $data): void
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
     * @return array<array-key, CapabilityArgumentLocalizationInterface>
     */
    private function transformMapCapabilityArgumentLocalization(array $data): array
    {
        return array_map(fn (array $item): CapabilityArgumentLocalizationInterface => $this->capabilityArgumentLocalizationTransformer->transform($item), array_filter($data, is_array(...)));
    }
}
