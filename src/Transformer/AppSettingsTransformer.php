<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AppSettings;
use ChristianBrown\SmartThings\Model\AppSettingsInterface;

use function array_combine;
use function array_filter;
use function array_keys;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class AppSettingsTransformer implements AppSettingsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AppSettingsInterface
    {
        $settings = new AppSettings();

        self::applySettings($settings, $data);

        return $settings;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySettings(AppSettings $settings, array $data): void
    {
        if (!isset($data[self::KEY_SETTINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_SETTINGS])) {
            return;
        }
        // Keep only string-valued entries and normalise their keys to strings so
        // the map is a clean array<string, string>.
        $stringValues = array_filter($data[self::KEY_SETTINGS], static fn (mixed $item): bool => is_string($item));
        $normalised = array_combine(
            array_map(static fn (int|string $key): string => (string) $key, array_keys($stringValues)),
            array_values($stringValues)
        );
        $settings->setSettings($normalised);
    }
}
