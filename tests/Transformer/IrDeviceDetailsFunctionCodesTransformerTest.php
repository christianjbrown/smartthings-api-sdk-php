<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\IrDeviceDetailsFunctionCodes;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsFunctionCodesTransformer;
use ChristianBrown\SmartThings\Transformer\IrDeviceDetailsFunctionCodesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(IrDeviceDetailsFunctionCodes::class)]
#[CoversClass(IrDeviceDetailsFunctionCodesTransformer::class)]
final class IrDeviceDetailsFunctionCodesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            IrDeviceDetailsFunctionCodesTransformerInterface::KEY_DEFAULT => 'test-default',
        ];

        $transformer = new IrDeviceDetailsFunctionCodesTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-default', $actual->getDefault());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new IrDeviceDetailsFunctionCodesTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'defaultAbsent' => [[], 'getDefault', null];
        yield 'defaultWrongType' => [[IrDeviceDetailsFunctionCodesTransformerInterface::KEY_DEFAULT => 42], 'getDefault', null];
        yield 'defaultValid' => [[IrDeviceDetailsFunctionCodesTransformerInterface::KEY_DEFAULT => 'test-default'], 'getDefault', 'test-default'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new IrDeviceDetailsFunctionCodesTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDefault());
    }
}
