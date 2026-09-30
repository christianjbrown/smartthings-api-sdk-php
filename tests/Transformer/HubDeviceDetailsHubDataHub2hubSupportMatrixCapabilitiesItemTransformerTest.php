<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItem;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItem::class)]
#[CoversClass(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer::class)]
final class HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME => 'test-name',
            HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION => 7,
        ];

        $transformer = new HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-name', $actual->getName());
        self::assertSame(7, $actual->getVersion());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'nameAbsent' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION => 7], 'getName', null];
        yield 'nameWrongType' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION => 7, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME => 42], 'getName', null];
        yield 'versionAbsent' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME => 'test-name'], 'getVersion', null];
        yield 'versionWrongType' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME => 'test-name', HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION => 'not-int'], 'getVersion', null];
    }
}
