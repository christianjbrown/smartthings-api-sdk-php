<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LambdaSmartApp;
use ChristianBrown\SmartThings\Transformer\LambdaSmartAppTransformer;
use ChristianBrown\SmartThings\Transformer\LambdaSmartAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LambdaSmartApp::class)]
#[CoversClass(LambdaSmartAppTransformer::class)]
final class LambdaSmartAppTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LambdaSmartAppTransformerInterface::KEY_FUNCTIONS => ['test-functions-1', 'test-functions-2'],
        ];

        $transformer = new LambdaSmartAppTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(['test-functions-1', 'test-functions-2'], $actual->getFunctions());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new LambdaSmartAppTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'functionsAbsent' => [[], 'getFunctions', null];
        yield 'functionsWrongType' => [[LambdaSmartAppTransformerInterface::KEY_FUNCTIONS => 'not-array'], 'getFunctions', null];
        yield 'functionsValid' => [[LambdaSmartAppTransformerInterface::KEY_FUNCTIONS => ['test-functions-1', 'test-functions-2']], 'getFunctions', ['test-functions-1', 'test-functions-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new LambdaSmartAppTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getFunctions());
    }
}
