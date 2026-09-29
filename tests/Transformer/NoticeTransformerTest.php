<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\Notice;
use ChristianBrown\SmartThings\Transformer\NoticeTransformer;
use ChristianBrown\SmartThings\Transformer\NoticeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Notice::class)]
#[CoversClass(NoticeTransformer::class)]
final class NoticeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            NoticeTransformerInterface::KEY_CODE => 'test-code',
            NoticeTransformerInterface::KEY_BADGE_URL => 'test-badge-url',
            NoticeTransformerInterface::KEY_MESSAGE => 'test-message',
            NoticeTransformerInterface::KEY_ACTIONS => ['test-actions-1', 'test-actions-2'],
        ];

        $transformer = new NoticeTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-code', $actual->getCode());
        self::assertSame('test-badge-url', $actual->getBadgeUrl());
        self::assertSame('test-message', $actual->getMessage());
        self::assertSame(['test-actions-1', 'test-actions-2'], $actual->getActions());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new NoticeTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'codeAbsent' => [[], 'getCode', null];
        yield 'codeWrongType' => [[NoticeTransformerInterface::KEY_CODE => 42], 'getCode', null];
        yield 'codeValid' => [[NoticeTransformerInterface::KEY_CODE => 'test-code'], 'getCode', 'test-code'];
        yield 'badgeUrlAbsent' => [[], 'getBadgeUrl', null];
        yield 'badgeUrlWrongType' => [[NoticeTransformerInterface::KEY_BADGE_URL => 42], 'getBadgeUrl', null];
        yield 'badgeUrlValid' => [[NoticeTransformerInterface::KEY_BADGE_URL => 'test-badge-url'], 'getBadgeUrl', 'test-badge-url'];
        yield 'messageAbsent' => [[], 'getMessage', null];
        yield 'messageWrongType' => [[NoticeTransformerInterface::KEY_MESSAGE => 42], 'getMessage', null];
        yield 'messageValid' => [[NoticeTransformerInterface::KEY_MESSAGE => 'test-message'], 'getMessage', 'test-message'];
        yield 'actionsAbsent' => [[], 'getActions', null];
        yield 'actionsWrongType' => [[NoticeTransformerInterface::KEY_ACTIONS => 'not-array'], 'getActions', null];
        yield 'actionsValid' => [[NoticeTransformerInterface::KEY_ACTIONS => ['test-actions-1', 'test-actions-2']], 'getActions', ['test-actions-1', 'test-actions-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new NoticeTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getCode());
        self::assertNull($actual->getBadgeUrl());
        self::assertNull($actual->getMessage());
        self::assertNull($actual->getActions());
    }
}
