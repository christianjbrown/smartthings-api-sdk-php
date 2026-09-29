<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrix;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HubDeviceDetailsHubDataHub2hubSupportMatrix::class)]
#[CoversClass(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformer::class)]
final class HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemModel = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer->method('transform')->willReturn($hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemModel);
        $data = [
            HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::KEY_CAPABILITIES => [['test-nested']],
        ];

        $transformer = new HubDeviceDetailsHubDataHub2hubSupportMatrixTransformer($hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemModel], $actual->getCapabilities());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new HubDeviceDetailsHubDataHub2hubSupportMatrixTransformer(self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'capabilitiesAbsent' => [[], sprintf(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::KEY_CAPABILITIES)];
        yield 'capabilitiesWrongType' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::KEY_CAPABILITIES => 'not-array'], sprintf(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::KEY_CAPABILITIES)];
    }
}
