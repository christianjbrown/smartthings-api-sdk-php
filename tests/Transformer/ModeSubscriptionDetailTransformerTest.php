<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ModeSubscriptionDetail;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformer;
use ChristianBrown\SmartThings\Transformer\ModeSubscriptionDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ModeSubscriptionDetail::class)]
#[CoversClass(ModeSubscriptionDetailTransformer::class)]
final class ModeSubscriptionDetailTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ModeSubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 'test-location-id',
        ];

        $transformer = new ModeSubscriptionDetailTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-location-id', $actual->getLocationId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ModeSubscriptionDetailTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'locationIdAbsent' => [[], sprintf(ModeSubscriptionDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, ModeSubscriptionDetailTransformerInterface::KEY_LOCATION_ID)];
        yield 'locationIdWrongType' => [[ModeSubscriptionDetailTransformerInterface::KEY_LOCATION_ID => 42], sprintf(ModeSubscriptionDetailTransformerInterface::UNEXPECTED_STRING_SPRINTF, ModeSubscriptionDetailTransformerInterface::KEY_LOCATION_ID)];
    }
}
