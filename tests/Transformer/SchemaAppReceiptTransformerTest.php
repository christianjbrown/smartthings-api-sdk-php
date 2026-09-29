<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppReceipt;
use ChristianBrown\SmartThings\Transformer\SchemaAppReceiptTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppReceiptTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppReceipt::class)]
#[CoversClass(SchemaAppReceiptTransformer::class)]
final class SchemaAppReceiptTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SchemaAppReceiptTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id',
            SchemaAppReceiptTransformerInterface::KEY_ST_CLIENT_ID => 'test-st-client-id',
            SchemaAppReceiptTransformerInterface::KEY_ST_CLIENT_SECRET => 'test-st-client-secret',
        ];

        $transformer = new SchemaAppReceiptTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-endpoint-app-id', $actual->getEndpointAppId());
        self::assertSame('test-st-client-id', $actual->getStClientId());
        self::assertSame('test-st-client-secret', $actual->getStClientSecret());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SchemaAppReceiptTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'endpointAppIdAbsent' => [[], 'getEndpointAppId', null];
        yield 'endpointAppIdWrongType' => [[SchemaAppReceiptTransformerInterface::KEY_ENDPOINT_APP_ID => 42], 'getEndpointAppId', null];
        yield 'endpointAppIdValid' => [[SchemaAppReceiptTransformerInterface::KEY_ENDPOINT_APP_ID => 'test-endpoint-app-id'], 'getEndpointAppId', 'test-endpoint-app-id'];
        yield 'stClientIdAbsent' => [[], 'getStClientId', null];
        yield 'stClientIdWrongType' => [[SchemaAppReceiptTransformerInterface::KEY_ST_CLIENT_ID => 42], 'getStClientId', null];
        yield 'stClientIdValid' => [[SchemaAppReceiptTransformerInterface::KEY_ST_CLIENT_ID => 'test-st-client-id'], 'getStClientId', 'test-st-client-id'];
        yield 'stClientSecretAbsent' => [[], 'getStClientSecret', null];
        yield 'stClientSecretWrongType' => [[SchemaAppReceiptTransformerInterface::KEY_ST_CLIENT_SECRET => 42], 'getStClientSecret', null];
        yield 'stClientSecretValid' => [[SchemaAppReceiptTransformerInterface::KEY_ST_CLIENT_SECRET => 'test-st-client-secret'], 'getStClientSecret', 'test-st-client-secret'];
    }
}
