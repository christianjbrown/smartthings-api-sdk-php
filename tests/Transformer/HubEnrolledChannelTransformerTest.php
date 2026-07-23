<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubEnrolledChannel;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelTransformer;
use ChristianBrown\SmartThings\Transformer\HubEnrolledChannelTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(HubEnrolledChannel::class)]
#[CoversClass(HubEnrolledChannelTransformer::class)]
final class HubEnrolledChannelTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HubEnrolledChannelTransformerInterface::KEY_CHANNEL_ID => 'test-channel-id',
            HubEnrolledChannelTransformerInterface::KEY_DESCRIPTION => 'Test description',
            HubEnrolledChannelTransformerInterface::KEY_NAME => 'Test Channel',
            HubEnrolledChannelTransformerInterface::KEY_SUBSCRIPTION_URL => 'https://example.com/subscribe',
        ];

        $transformer = new HubEnrolledChannelTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-channel-id', $actual->getChannelId());
        self::assertSame('Test description', $actual->getDescription());
        self::assertSame('Test Channel', $actual->getName());
        self::assertSame('https://example.com/subscribe', $actual->getSubscriptionUrl());
    }

    /**
     * Exercises every optional field's absent / wrong-type / valid branches.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $data, ?string $expectedDescription, ?string $expectedName, ?string $expectedSubscriptionUrl): void
    {
        $transformer = new HubEnrolledChannelTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-channel-id', $actual->getChannelId());
        self::assertSame($expectedDescription, $actual->getDescription());
        self::assertSame($expectedName, $actual->getName());
        self::assertSame($expectedSubscriptionUrl, $actual->getSubscriptionUrl());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        $id = HubEnrolledChannelTransformerInterface::KEY_CHANNEL_ID;
        $description = HubEnrolledChannelTransformerInterface::KEY_DESCRIPTION;
        $name = HubEnrolledChannelTransformerInterface::KEY_NAME;
        $url = HubEnrolledChannelTransformerInterface::KEY_SUBSCRIPTION_URL;

        yield 'allAbsent' => [[$id => 'test-channel-id'], null, null, null];
        yield 'allValid' => [[$id => 'test-channel-id', $description => 'Test description', $name => 'Test Channel', $url => 'https://example.com/subscribe'], 'Test description', 'Test Channel', 'https://example.com/subscribe'];
        yield 'descriptionWrongType' => [[$id => 'test-channel-id', $description => 42], null, null, null];
        yield 'nameWrongType' => [[$id => 'test-channel-id', $name => 42], null, null, null];
        yield 'subscriptionUrlWrongType' => [[$id => 'test-channel-id', $url => 42], null, null, null];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[HubEnrolledChannelTransformerInterface::KEY_CHANNEL_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new HubEnrolledChannelTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(HubEnrolledChannelTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubEnrolledChannelTransformerInterface::KEY_CHANNEL_ID));
        $transformer->transform($data);
    }
}
