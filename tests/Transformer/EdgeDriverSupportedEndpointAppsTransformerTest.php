<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointApps;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItemInterface;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EdgeDriverSupportedEndpointApps::class)]
#[CoversClass(EdgeDriverSupportedEndpointAppsTransformer::class)]
final class EdgeDriverSupportedEndpointAppsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $edgeDriverSupportedEndpointAppsAppsItemModel = self::createStub(EdgeDriverSupportedEndpointAppsAppsItemInterface::class);
        $edgeDriverSupportedEndpointAppsAppsItemTransformer = self::createStub(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::class);
        $edgeDriverSupportedEndpointAppsAppsItemTransformer->method('transform')->willReturn($edgeDriverSupportedEndpointAppsAppsItemModel);
        $data = [
            EdgeDriverSupportedEndpointAppsTransformerInterface::KEY_APPS => [['test-nested']],
        ];

        $transformer = new EdgeDriverSupportedEndpointAppsTransformer($edgeDriverSupportedEndpointAppsAppsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$edgeDriverSupportedEndpointAppsAppsItemModel], $actual->getApps());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new EdgeDriverSupportedEndpointAppsTransformer(self::createStub(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'appsAbsent' => [[], 'getApps', []];
        yield 'appsWrongType' => [[EdgeDriverSupportedEndpointAppsTransformerInterface::KEY_APPS => 'not-array'], 'getApps', []];
    }
}
