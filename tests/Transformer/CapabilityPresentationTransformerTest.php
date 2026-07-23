<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityPresentation;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityPresentationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilityPresentation::class)]
#[CoversClass(CapabilityPresentationTransformer::class)]
final class CapabilityPresentationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CapabilityPresentationTransformerInterface::KEY_ID => 'switch',
            CapabilityPresentationTransformerInterface::KEY_VERSION => 1,
        ];

        $transformer = new CapabilityPresentationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('switch', $actual->getId());
        self::assertSame(1, $actual->getVersion());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[CapabilityPresentationTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new CapabilityPresentationTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityPresentationTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilityPresentationTransformerInterface::KEY_ID));
        $transformer->transform($data);
    }

    /**
     * Exercises the optional version field across its states: absent, wrong-type,
     * and the falsy-but-legitimate `0`.
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformVersionCases')]
    public function testTransformVersion(array $data, ?int $expectedVersion): void
    {
        $transformer = new CapabilityPresentationTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('switch', $actual->getId());
        self::assertSame($expectedVersion, $actual->getVersion());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?int}>
     */
    public static function provideTransformVersionCases(): iterable
    {
        $id = CapabilityPresentationTransformerInterface::KEY_ID;
        $version = CapabilityPresentationTransformerInterface::KEY_VERSION;

        yield 'versionValid' => [[$id => 'switch', $version => 1], 1];
        yield 'versionZero' => [[$id => 'switch', $version => 0], 0];
        yield 'versionAbsent' => [[$id => 'switch'], null];
        yield 'versionWrongType' => [[$id => 'switch', $version => 'not-an-int'], null];
    }
}
