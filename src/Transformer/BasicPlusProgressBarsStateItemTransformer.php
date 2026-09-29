<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItem;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;
use function sprintf;

final class BasicPlusProgressBarsStateItemTransformer implements BasicPlusProgressBarsStateItemTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;
    private DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer, DeviceConfigEntryForDashboardStateFormatInfoItemTransformerInterface $deviceConfigEntryForDashboardStateFormatInfoItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
        $this->deviceConfigEntryForDashboardStateFormatInfoItemTransformer = $deviceConfigEntryForDashboardStateFormatInfoItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusProgressBarsStateItemInterface
    {
        $model = new BasicPlusProgressBarsStateItem(self::requireLabel($data), self::requireCapability($data), self::requireComponent($data));

        $this->applyAlternatives($model, $data);
        self::applyVersion($model, $data);
        $this->applyFormatInfo($model, $data);
        self::applyIconUrl($model, $data);
        self::applyPlacement($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(BasicPlusProgressBarsStateItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        if (!is_array($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        $model->setAlternatives($this->transformListAlternativeItem($data[self::KEY_ALTERNATIVES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFormatInfo(BasicPlusProgressBarsStateItem $model, array $data): void
    {
        if (!isset($data[self::KEY_FORMAT_INFO])) {
            return;
        }
        if (!is_array($data[self::KEY_FORMAT_INFO])) {
            return;
        }
        $model->setFormatInfo($this->transformListDeviceConfigEntryForDashboardStateFormatInfoItem($data[self::KEY_FORMAT_INFO]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIconUrl(BasicPlusProgressBarsStateItem $model, array $data): void
    {
        if (empty($data[self::KEY_ICON_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            return;
        }
        $model->setIconUrl($data[self::KEY_ICON_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPlacement(BasicPlusProgressBarsStateItem $model, array $data): void
    {
        if (empty($data[self::KEY_PLACEMENT])) {
            return;
        }
        if (!is_string($data[self::KEY_PLACEMENT])) {
            return;
        }
        $model->setPlacement($data[self::KEY_PLACEMENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(BasicPlusProgressBarsStateItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireComponent(array $data): string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COMPONENT));
        }

        return $data[self::KEY_COMPONENT];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLabel(array $data): string
    {
        if (empty($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }
        if (!is_string($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }

        return $data[self::KEY_LABEL];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function transformListAlternativeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AlternativeItemInterface => $this->alternativeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface>
     */
    private function transformListDeviceConfigEntryForDashboardStateFormatInfoItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigEntryForDashboardStateFormatInfoItemInterface => $this->deviceConfigEntryForDashboardStateFormatInfoItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
