<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItem;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EdgeDriverSupportedEndpointAppsAppsItem::class)]
#[CoversClass(EdgeDriverSupportedEndpointAppsAppsItemTransformer::class)]
final class EdgeDriverSupportedEndpointAppsAppsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 'test-app-name',
            EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 'test-version',
        ];

        $transformer = new EdgeDriverSupportedEndpointAppsAppsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-app-name', $actual->getAppName());
        self::assertSame('test-version', $actual->getVersion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new EdgeDriverSupportedEndpointAppsAppsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'appNameAbsent' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 'test-version'], 'getAppName', null];
        yield 'appNameWrongType' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 'test-version', EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 42], 'getAppName', null];
        yield 'versionAbsent' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 'test-app-name'], 'getVersion', null];
        yield 'versionWrongType' => [[EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_APP_NAME => 'test-app-name', EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::KEY_VERSION => 42], 'getVersion', null];
    }
}
