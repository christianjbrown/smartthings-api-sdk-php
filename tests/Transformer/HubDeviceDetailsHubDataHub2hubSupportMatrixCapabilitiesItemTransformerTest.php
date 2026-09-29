<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItem;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'nameAbsent' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION => 7], sprintf(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME)];
        yield 'nameWrongType' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION => 7, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME => 42], sprintf(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME)];
        yield 'versionAbsent' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME => 'test-name'], sprintf(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::UNEXPECTED_INT_SPRINTF, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION)];
        yield 'versionWrongType' => [[HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_NAME => 'test-name', HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION => 'not-int'], sprintf(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::UNEXPECTED_INT_SPRINTF, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface::KEY_VERSION)];
    }
}
