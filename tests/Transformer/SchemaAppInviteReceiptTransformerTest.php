<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\SchemaAppInviteReceipt;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteReceiptTransformer;
use ChristianBrown\SmartThings\Transformer\SchemaAppInviteReceiptTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SchemaAppInviteReceipt::class)]
#[CoversClass(SchemaAppInviteReceiptTransformer::class)]
final class SchemaAppInviteReceiptTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            SchemaAppInviteReceiptTransformerInterface::KEY_INVITATION_ID => 'test-invitation-id',
            SchemaAppInviteReceiptTransformerInterface::KEY_SHORT_CODE => 'test-short-code',
        ];

        $transformer = new SchemaAppInviteReceiptTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-invitation-id', $actual->getInvitationId());
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
        $transformer = new SchemaAppInviteReceiptTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'invitationIdAbsent' => [[], 'getInvitationId', null];
        yield 'invitationIdWrongType' => [[SchemaAppInviteReceiptTransformerInterface::KEY_INVITATION_ID => 42], 'getInvitationId', null];
        yield 'invitationIdValid' => [[SchemaAppInviteReceiptTransformerInterface::KEY_INVITATION_ID => 'test-invitation-id'], 'getInvitationId', 'test-invitation-id'];
        yield 'shortCodeAbsent' => [[], 'getShortCode', null];
        yield 'shortCodeWrongType' => [[SchemaAppInviteReceiptTransformerInterface::KEY_SHORT_CODE => 42], 'getShortCode', null];
        yield 'shortCodeValid' => [[SchemaAppInviteReceiptTransformerInterface::KEY_SHORT_CODE => 'test-short-code'], 'getShortCode', 'test-short-code'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new SchemaAppInviteReceiptTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getInvitationId());
        self::assertNull($actual->getShortCode());
    }
}
