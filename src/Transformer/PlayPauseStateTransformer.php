<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\PlayPauseState;
use ChristianBrown\SmartThings\Model\PlayPauseStateInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class PlayPauseStateTransformer implements PlayPauseStateTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PlayPauseStateInterface
    {
        $model = new PlayPauseState(self::requireValue($data), self::requirePlay($data), self::requirePause($data));

        self::applyValueType($model, $data);
        $this->applyAlternatives($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(PlayPauseState $model, array $data): void
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
    private static function applyValueType(PlayPauseState $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        $model->setValueType($data[self::KEY_VALUE_TYPE]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requirePause(array $data): ?string
    {
        if (empty($data[self::KEY_PAUSE])) {
            return null;
        }
        if (!is_string($data[self::KEY_PAUSE])) {
            return null;
        }

        return $data[self::KEY_PAUSE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requirePlay(array $data): ?string
    {
        if (empty($data[self::KEY_PLAY])) {
            return null;
        }
        if (!is_string($data[self::KEY_PLAY])) {
            return null;
        }

        return $data[self::KEY_PLAY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): ?string
    {
        if (empty($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return null;
        }

        return $data[self::KEY_VALUE];
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
