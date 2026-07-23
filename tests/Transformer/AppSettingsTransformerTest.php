<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AppSettings;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformer;
use ChristianBrown\SmartThings\Transformer\AppSettingsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppSettings::class)]
#[CoversClass(AppSettingsTransformer::class)]
final class AppSettingsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            AppSettingsTransformerInterface::KEY_SETTINGS => ['key1' => 'value1', 'key2' => 'value2'],
        ];

        $transformer = new AppSettingsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['key1' => 'value1', 'key2' => 'value2'], $actual->getSettings());
    }

    public function testTransformAbsent(): void
    {
        $transformer = new AppSettingsTransformer();

        $actual = $transformer->transform([]);

        self::assertSame([], $actual->getSettings());
    }

    public function testTransformFiltersNonStringValues(): void
    {
        $data = [
            AppSettingsTransformerInterface::KEY_SETTINGS => ['key1' => 'value1', 'key2' => 42, 'key3' => 'value3'],
        ];

        $transformer = new AppSettingsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['key1' => 'value1', 'key3' => 'value3'], $actual->getSettings());
    }

    public function testTransformNotArray(): void
    {
        $transformer = new AppSettingsTransformer();

        $actual = $transformer->transform([AppSettingsTransformerInterface::KEY_SETTINGS => 'not-an-array']);

        self::assertSame([], $actual->getSettings());
    }
}
