<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItem;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemArgumentsItemTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(DeviceConfigurationDpInfoItemArgumentsItem::class)]
#[CoversClass(DeviceConfigurationDpInfoItemArgumentsItemTransformer::class)]
final class DeviceConfigurationDpInfoItemArgumentsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 'test-key',
            DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 'test-value',
        ];

        $transformer = new DeviceConfigurationDpInfoItemArgumentsItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-key', $actual->getKey());
        self::assertSame('test-value', $actual->getValue());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new DeviceConfigurationDpInfoItemArgumentsItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'keyAbsent' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 'test-value'], sprintf(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY)];
        yield 'keyWrongType' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 'test-value', DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 42], sprintf(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY)];
        yield 'valueAbsent' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 'test-key'], sprintf(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE)];
        yield 'valueWrongType' => [[DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_KEY => 'test-key', DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE => 42], sprintf(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface::KEY_VALUE)];
    }
}
