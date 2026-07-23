<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ChannelDriver;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ChannelDriver::class)]
#[CoversClass(ChannelDriverTransformer::class)]
final class ChannelDriverTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ChannelDriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            ChannelDriverTransformerInterface::KEY_CHANNEL_ID => 'test-channel-id',
            ChannelDriverTransformerInterface::KEY_VERSION => '2024-01-01',
        ];

        $transformer = new ChannelDriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame('test-channel-id', $actual->getChannelId());
        self::assertSame('2024-01-01', $actual->getVersion());
    }

    /**
     * Exercises the optional channelId/version fields (absent / wrong-type / valid).
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedChannelId, ?string $expectedVersion): void
    {
        $transformer = new ChannelDriverTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame($expectedChannelId, $actual->getChannelId());
        self::assertSame($expectedVersion, $actual->getVersion());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $driverId = ChannelDriverTransformerInterface::KEY_DRIVER_ID;
        $channelId = ChannelDriverTransformerInterface::KEY_CHANNEL_ID;
        $version = ChannelDriverTransformerInterface::KEY_VERSION;

        yield 'allAbsent' => [[$driverId => 'test-driver-id'], null, null];
        yield 'allValid' => [[$driverId => 'test-driver-id', $channelId => 'test-channel-id', $version => '2024-01-01'], 'test-channel-id', '2024-01-01'];
        yield 'channelIdWrongType' => [[$driverId => 'test-driver-id', $channelId => 42], null, null];
        yield 'versionWrongType' => [[$driverId => 'test-driver-id', $version => 42], null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ChannelDriverTransformerInterface::KEY_DRIVER_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ChannelDriverTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ChannelDriverTransformerInterface::UNEXPECTED_STRING_SPRINTF, ChannelDriverTransformerInterface::KEY_DRIVER_ID));
        $transformer->transform($data);
    }
}
