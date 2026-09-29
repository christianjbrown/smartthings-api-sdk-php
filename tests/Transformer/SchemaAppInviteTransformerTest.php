<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInvite;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppInvite::class)]
#[CoversClass(SchemaAppInviteTransformer::class)]
final class SchemaAppInviteTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SchemaAppInviteTransformerInterface::KEY_ID => 'test-id',
            SchemaAppInviteTransformerInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id',
            SchemaAppInviteTransformerInterface::KEY_DESCRIPTION => 'test-description',
            SchemaAppInviteTransformerInterface::KEY_EXPIRATION => 1.5,
            SchemaAppInviteTransformerInterface::KEY_ACCEPT_URL => 'test-accept-url',
            SchemaAppInviteTransformerInterface::KEY_DECLINE_URL => 'test-decline-url',
            SchemaAppInviteTransformerInterface::KEY_SHORT_CODE => 'test-short-code',
        ];

        $transformer = new SchemaAppInviteTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-id', $actual->getId());
        self::assertSame('test-schema-app-id', $actual->getSchemaAppId());
        self::assertSame('test-description', $actual->getDescription());
        self::assertSame(1.5, $actual->getExpiration());
        self::assertSame('test-accept-url', $actual->getAcceptUrl());
        self::assertSame('test-decline-url', $actual->getDeclineUrl());
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
        $transformer = new SchemaAppInviteTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'idAbsent' => [[], 'getId', null];
        yield 'idWrongType' => [[SchemaAppInviteTransformerInterface::KEY_ID => 42], 'getId', null];
        yield 'idValid' => [[SchemaAppInviteTransformerInterface::KEY_ID => 'test-id'], 'getId', 'test-id'];
        yield 'schemaAppIdAbsent' => [[], 'getSchemaAppId', null];
        yield 'schemaAppIdWrongType' => [[SchemaAppInviteTransformerInterface::KEY_SCHEMA_APP_ID => 42], 'getSchemaAppId', null];
        yield 'schemaAppIdValid' => [[SchemaAppInviteTransformerInterface::KEY_SCHEMA_APP_ID => 'test-schema-app-id'], 'getSchemaAppId', 'test-schema-app-id'];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[SchemaAppInviteTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[SchemaAppInviteTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'expirationAbsent' => [[], 'getExpiration', null];
        yield 'expirationWrongType' => [[SchemaAppInviteTransformerInterface::KEY_EXPIRATION => 'not-number'], 'getExpiration', null];
        yield 'expirationValid' => [[SchemaAppInviteTransformerInterface::KEY_EXPIRATION => 1.5], 'getExpiration', 1.5];
        yield 'acceptUrlAbsent' => [[], 'getAcceptUrl', null];
        yield 'acceptUrlWrongType' => [[SchemaAppInviteTransformerInterface::KEY_ACCEPT_URL => 42], 'getAcceptUrl', null];
        yield 'acceptUrlValid' => [[SchemaAppInviteTransformerInterface::KEY_ACCEPT_URL => 'test-accept-url'], 'getAcceptUrl', 'test-accept-url'];
        yield 'declineUrlAbsent' => [[], 'getDeclineUrl', null];
        yield 'declineUrlWrongType' => [[SchemaAppInviteTransformerInterface::KEY_DECLINE_URL => 42], 'getDeclineUrl', null];
        yield 'declineUrlValid' => [[SchemaAppInviteTransformerInterface::KEY_DECLINE_URL => 'test-decline-url'], 'getDeclineUrl', 'test-decline-url'];
        yield 'shortCodeAbsent' => [[], 'getShortCode', null];
        yield 'shortCodeWrongType' => [[SchemaAppInviteTransformerInterface::KEY_SHORT_CODE => 42], 'getShortCode', null];
        yield 'shortCodeValid' => [[SchemaAppInviteTransformerInterface::KEY_SHORT_CODE => 'test-short-code'], 'getShortCode', 'test-short-code'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new SchemaAppInviteTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getId());
        self::assertNull($actual->getSchemaAppId());
        self::assertNull($actual->getDescription());
        self::assertNull($actual->getExpiration());
        self::assertNull($actual->getAcceptUrl());
        self::assertNull($actual->getDeclineUrl());
        self::assertNull($actual->getShortCode());
    }
}
