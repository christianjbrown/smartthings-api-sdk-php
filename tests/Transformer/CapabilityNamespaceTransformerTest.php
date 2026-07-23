<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\CapabilityNamespace;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespaceTransformer;
use ChristianBrown\SmartThings\Transformer\CapabilityNamespaceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CapabilityNamespace::class)]
#[CoversClass(CapabilityNamespaceTransformer::class)]
final class CapabilityNamespaceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CapabilityNamespaceTransformerInterface::KEY_NAME => 'test-namespace',
            CapabilityNamespaceTransformerInterface::KEY_OWNER_ID => 'test-owner-id',
            CapabilityNamespaceTransformerInterface::KEY_OWNER_TYPE => 'USER',
        ];

        $transformer = new CapabilityNamespaceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-namespace', $actual->getName());
        self::assertSame('test-owner-id', $actual->getOwnerId());
        self::assertSame('USER', $actual->getOwnerType());
    }

    /**
     * Exercises the two optional fields across each of their states (absent /
     * wrong-type / valid).
     *
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformOptionalFieldCombinationsCases')]
    public function testTransformOptionalFieldCombinations(array $data, ?string $expectedOwnerId, ?string $expectedOwnerType): void
    {
        $transformer = new CapabilityNamespaceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-namespace', $actual->getName());
        self::assertSame($expectedOwnerId, $actual->getOwnerId());
        self::assertSame($expectedOwnerType, $actual->getOwnerType());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, ?string, ?string}>
     */
    public static function provideTransformOptionalFieldCombinationsCases(): iterable
    {
        $ownerIdStates = [
            'ownerIdAbsent' => [null, null],
            'ownerIdWrongType' => [42, null],
            'ownerIdValid' => ['test-owner-id', 'test-owner-id'],
        ];
        $ownerTypeStates = [
            'ownerTypeAbsent' => [null, null],
            'ownerTypeWrongType' => [42, null],
            'ownerTypeValid' => ['USER', 'USER'],
        ];

        foreach ($ownerIdStates as $ownerIdName => [$ownerIdValue, $expectedOwnerId]) {
            foreach ($ownerTypeStates as $ownerTypeName => [$ownerTypeValue, $expectedOwnerType]) {
                $data = [CapabilityNamespaceTransformerInterface::KEY_NAME => 'test-namespace'];
                if (null !== $ownerIdValue) {
                    $data[CapabilityNamespaceTransformerInterface::KEY_OWNER_ID] = $ownerIdValue;
                }
                if (null !== $ownerTypeValue) {
                    $data[CapabilityNamespaceTransformerInterface::KEY_OWNER_TYPE] = $ownerTypeValue;
                }

                yield sprintf('%s, %s', $ownerIdName, $ownerTypeName) => [$data, $expectedOwnerId, $expectedOwnerType];
            }
        }
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[CapabilityNamespaceTransformerInterface::KEY_NAME => 42]])]
    public function testTransformUnexpectedData(array $data): void
    {
        $transformer = new CapabilityNamespaceTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CapabilityNamespaceTransformerInterface::UNEXPECTED_STRING_SPRINTF, CapabilityNamespaceTransformerInterface::KEY_NAME));
        $transformer->transform($data);
    }
}
