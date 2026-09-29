<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StateWithAvailableSize;
use ChristianBrown\SmartThings\Model\StateWithAvailableSizeInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class StateWithAvailableSizeTransformer implements StateWithAvailableSizeTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): StateWithAvailableSizeInterface
    {
        $model = new StateWithAvailableSize(self::requireLabel($data));

        self::applyUnit($model, $data);
        $this->applyAlternatives($model, $data);
        self::applyAvailableSizes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(StateWithAvailableSize $model, array $data): void
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
    private static function applyAvailableSizes(StateWithAvailableSize $model, array $data): void
    {
        if (!isset($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        if (!is_array($data[self::KEY_AVAILABLE_SIZES])) {
            return;
        }
        $model->setAvailableSizes(array_values(array_filter($data[self::KEY_AVAILABLE_SIZES], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(StateWithAvailableSize $model, array $data): void
    {
        if (empty($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return;
        }
        $model->setUnit($data[self::KEY_UNIT]);
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
}
