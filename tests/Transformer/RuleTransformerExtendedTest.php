<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Model\Rule;
use ChristianBrown\SmartThings\Transformer\ActionTransformerInterface;
use ChristianBrown\SmartThings\Transformer\RuleTransformer;
use ChristianBrown\SmartThings\Transformer\RuleTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Rule::class)]
#[CoversClass(RuleTransformer::class)]
final class RuleTransformerExtendedTest extends TestCase
{
    public function testTransformExtendedActions(): void
    {
        $nested = [self::createStub(ActionInterface::class)];
        $nestedTransformer = self::createMock(ActionTransformerInterface::class);
        $nestedTransformer->expects(self::once())->method('transformAll')
            ->with(['test-nested'])
            ->willReturn($nested);

        $transformer = new RuleTransformer($nestedTransformer);
        $base = [RuleTransformerInterface::KEY_ID => 'test-rule-id'];

        self::assertSame([], $transformer->transform($base)->getActions());
        self::assertSame([], $transformer->transform($base + [RuleTransformerInterface::KEY_ACTIONS => 'not-array'])->getActions());
        self::assertSame($nested, $transformer->transform($base + [RuleTransformerInterface::KEY_ACTIONS => ['test-nested']])->getActions());
    }

    /**
     * Each new field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new RuleTransformer(self::createStub(ActionTransformerInterface::class));

        $actual = $transformer->transform([RuleTransformerInterface::KEY_ID => 'test-rule-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'timeZoneIdAbsent' => [[], 'getTimeZoneId', null];
        yield 'timeZoneIdWrongType' => [[RuleTransformerInterface::KEY_TIME_ZONE_ID => 42], 'getTimeZoneId', null];
        yield 'timeZoneIdValid' => [[RuleTransformerInterface::KEY_TIME_ZONE_ID => 'test-time-zone-id'], 'getTimeZoneId', 'test-time-zone-id'];
        yield 'executionLocationAbsent' => [[], 'getExecutionLocation', null];
        yield 'executionLocationWrongType' => [[RuleTransformerInterface::KEY_EXECUTION_LOCATION => 42], 'getExecutionLocation', null];
        yield 'executionLocationValid' => [[RuleTransformerInterface::KEY_EXECUTION_LOCATION => 'test-execution-location'], 'getExecutionLocation', 'test-execution-location'];
        yield 'ownerIdAbsent' => [[], 'getOwnerId', null];
        yield 'ownerIdWrongType' => [[RuleTransformerInterface::KEY_OWNER_ID => 42], 'getOwnerId', null];
        yield 'ownerIdValid' => [[RuleTransformerInterface::KEY_OWNER_ID => 'test-owner-id'], 'getOwnerId', 'test-owner-id'];
        yield 'ownerTypeAbsent' => [[], 'getOwnerType', null];
        yield 'ownerTypeWrongType' => [[RuleTransformerInterface::KEY_OWNER_TYPE => 42], 'getOwnerType', null];
        yield 'ownerTypeValid' => [[RuleTransformerInterface::KEY_OWNER_TYPE => 'test-owner-type'], 'getOwnerType', 'test-owner-type'];
        yield 'creatorAbsent' => [[], 'getCreator', null];
        yield 'creatorWrongType' => [[RuleTransformerInterface::KEY_CREATOR => 42], 'getCreator', null];
        yield 'creatorValid' => [[RuleTransformerInterface::KEY_CREATOR => 'test-creator'], 'getCreator', 'test-creator'];
        yield 'dateCreatedAbsent' => [[], 'getDateCreated', null];
        yield 'dateCreatedWrongType' => [[RuleTransformerInterface::KEY_DATE_CREATED => 42], 'getDateCreated', null];
        yield 'dateCreatedValid' => [[RuleTransformerInterface::KEY_DATE_CREATED => 'test-date-created'], 'getDateCreated', 'test-date-created'];
        yield 'dateUpdatedAbsent' => [[], 'getDateUpdated', null];
        yield 'dateUpdatedWrongType' => [[RuleTransformerInterface::KEY_DATE_UPDATED => 42], 'getDateUpdated', null];
        yield 'dateUpdatedValid' => [[RuleTransformerInterface::KEY_DATE_UPDATED => 'test-date-updated'], 'getDateUpdated', 'test-date-updated'];
        yield 'allowedAbsent' => [[], 'getAllowed', null];
        yield 'allowedWrongType' => [[RuleTransformerInterface::KEY_ALLOWED => 42], 'getAllowed', null];
        yield 'allowedValid' => [[RuleTransformerInterface::KEY_ALLOWED => 'test-allowed'], 'getAllowed', 'test-allowed'];
    }

    public function testTransformExtendedSequence(): void
    {
        $nested = self::createStub(ActionSequenceInterface::class);
        $nestedTransformer = self::createMock(ActionTransformerInterface::class);
        $nestedTransformer->expects(self::once())->method('transformActionSequence')
            ->with(['test-nested'])
            ->willReturn($nested);

        $transformer = new RuleTransformer($nestedTransformer);
        $base = [RuleTransformerInterface::KEY_ID => 'test-rule-id'];

        self::assertNull($transformer->transform($base)->getSequence());
        self::assertNull($transformer->transform($base + [RuleTransformerInterface::KEY_SEQUENCE => 'not-array'])->getSequence());
        self::assertSame($nested, $transformer->transform($base + [RuleTransformerInterface::KEY_SEQUENCE => ['test-nested']])->getSequence());
    }
}
