<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Channel;
use ChristianBrown\SmartThings\Transformer\ChannelTransformer;
use ChristianBrown\SmartThings\Transformer\ChannelTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Channel::class)]
#[CoversClass(ChannelTransformer::class)]
final class ChannelTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ChannelTransformerInterface::KEY_CHANNEL_ID => 'test-channel-id',
            ChannelTransformerInterface::KEY_DESCRIPTION => 'Test description',
            ChannelTransformerInterface::KEY_NAME => 'Test Channel',
            ChannelTransformerInterface::KEY_TERMS_OF_SERVICE_URL => 'https://example.com/tos',
            ChannelTransformerInterface::KEY_TYPE => 'DRIVER',
        ];

        $transformer = new ChannelTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-channel-id', $actual->getChannelId());
        self::assertSame('Test description', $actual->getDescription());
        self::assertSame('Test Channel', $actual->getName());
        self::assertSame('https://example.com/tos', $actual->getTermsOfServiceUrl());
        self::assertSame('DRIVER', $actual->getType());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedDescription, ?string $expectedName, ?string $expectedTermsOfServiceUrl, ?string $expectedType): void
    {
        $transformer = new ChannelTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-channel-id', $actual->getChannelId());
        self::assertSame($expectedDescription, $actual->getDescription());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedTermsOfServiceUrl, $actual->getTermsOfServiceUrl());
        self::assertSame($expectedType, $actual->getType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = ChannelTransformerInterface::KEY_CHANNEL_ID;
        $description = ChannelTransformerInterface::KEY_DESCRIPTION;
        $name = ChannelTransformerInterface::KEY_NAME;
        $tos = ChannelTransformerInterface::KEY_TERMS_OF_SERVICE_URL;
        $type = ChannelTransformerInterface::KEY_TYPE;

        yield 'allAbsent' => [[$id => 'test-channel-id'], null, null, null, null];
        yield 'allValid' => [[$id => 'test-channel-id', $description => 'Test description', $name => 'Test Channel', $tos => 'https://example.com/tos', $type => 'DRIVER'], 'Test description', 'Test Channel', 'https://example.com/tos', 'DRIVER'];
        yield 'descriptionWrongType' => [[$id => 'test-channel-id', $description => 42], null, null, null, null];
        yield 'nameWrongType' => [[$id => 'test-channel-id', $name => 42], null, null, null, null];
        yield 'termsOfServiceUrlWrongType' => [[$id => 'test-channel-id', $tos => 42], null, null, null, null];
        yield 'typeWrongType' => [[$id => 'test-channel-id', $type => 42], null, null, null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ChannelTransformerInterface::KEY_CHANNEL_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new ChannelTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ChannelTransformerInterface::UNEXPECTED_STRING_SPRINTF, ChannelTransformerInterface::KEY_CHANNEL_ID));
        $transformer->transform($data);
    }
}
