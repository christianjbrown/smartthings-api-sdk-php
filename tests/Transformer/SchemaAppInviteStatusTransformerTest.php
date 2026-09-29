<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteStatus;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteStatusTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteStatusTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppInviteStatus::class)]
#[CoversClass(SchemaAppInviteStatusTransformer::class)]
final class SchemaAppInviteStatusTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SchemaAppInviteStatusTransformerInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id',
            SchemaAppInviteStatusTransformerInterface::KEY_IS_ACCEPTED => true,
            SchemaAppInviteStatusTransformerInterface::KEY_DESCRIPTION => 'test-description',
            SchemaAppInviteStatusTransformerInterface::KEY_EXPIRATION => 1.5,
            SchemaAppInviteStatusTransformerInterface::KEY_SHORT_CODE => 'test-short-code',
        ];

        $transformer = new SchemaAppInviteStatusTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-schema-app-id', $actual->getSchemaAppId());
        self::assertTrue($actual->getIsAccepted());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame(1.5, $actual->getExpiration());
        self::assertSame('test-short-code', $actual->getShortCode());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new SchemaAppInviteStatusTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'schemaAppIdAbsent' => [[], 'getSchemaAppId', null];
        yield 'schemaAppIdWrongType' => [[SchemaAppInviteStatusTransformerInterface::KEY_SCHEMA_APP_ID => 42], 'getSchemaAppId', null];
        yield 'schemaAppIdValid' => [[SchemaAppInviteStatusTransformerInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id'], 'getSchemaAppId', 'test-schema-app-id'];
        yield 'isAcceptedAbsent' => [[], 'getIsAccepted', null];
        yield 'isAcceptedWrongType' => [[SchemaAppInviteStatusTransformerInterface::KEY_IS_ACCEPTED => 'not-bool'], 'getIsAccepted', null];
        yield 'isAcceptedValid' => [[SchemaAppInviteStatusTransformerInterface::KEY_IS_ACCEPTED => true], 'getIsAccepted', true];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[SchemaAppInviteStatusTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[SchemaAppInviteStatusTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'expirationAbsent' => [[], 'getExpiration', null];
        yield 'expirationWrongType' => [[SchemaAppInviteStatusTransformerInterface::KEY_EXPIRATION => 'not-number'], 'getExpiration', null];
        yield 'expirationValid' => [[SchemaAppInviteStatusTransformerInterface::KEY_EXPIRATION => 1.5], 'getExpiration', 1.5];
        yield 'shortCodeAbsent' => [[], 'getShortCode', null];
        yield 'shortCodeWrongType' => [[SchemaAppInviteStatusTransformerInterface::KEY_SHORT_CODE => 42], 'getShortCode', null];
        yield 'shortCodeValid' => [[SchemaAppInviteStatusTransformerInterface::KEY_SHORT_CODE => 'test-short-code'], 'getShortCode', 'test-short-code'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new SchemaAppInviteStatusTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getSchemaAppId());
        self::assertNull($actual->getIsAccepted());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getExpiration());
        self::assertNull($actual->getShortCode());
    }
}
