<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteAcceptance;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteAcceptanceTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteAcceptanceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppInviteAcceptance::class)]
#[CoversClass(SchemaAppInviteAcceptanceTransformer::class)]
final class SchemaAppInviteAcceptanceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SchemaAppInviteAcceptanceTransformerInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id',
        ];

        $transformer = new SchemaAppInviteAcceptanceTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-schema-app-id', $actual->getSchemaAppId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SchemaAppInviteAcceptanceTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'schemaAppIdAbsent' => [[], 'getSchemaAppId', null];
        yield 'schemaAppIdWrongType' => [[SchemaAppInviteAcceptanceTransformerInterface::KEY_SCHEMA_APP_ID => 42], 'getSchemaAppId', null];
        yield 'schemaAppIdValid' => [[SchemaAppInviteAcceptanceTransformerInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id'], 'getSchemaAppId', 'test-schema-app-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new SchemaAppInviteAcceptanceTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getSchemaAppId());
    }
}
