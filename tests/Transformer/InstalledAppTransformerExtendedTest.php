<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\InstalledApp;
use ChristianBrown\SmartThings\Model\InstalledAppDetailsInterface;
use ChristianBrown\SmartThings\Model\InstalledAppIconImageInterface;
use ChristianBrown\SmartThings\Model\InstalledAppUiInterface;
use ChristianBrown\SmartThings\Model\NoticeInterface;
use ChristianBrown\SmartThings\Model\OwnerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformer;
use ChristianBrown\SmartThings\Transformer\InstalledAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(InstalledApp::class)]
#[CoversClass(InstalledAppTransformer::class)]
final class InstalledAppTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new InstalledAppTransformer(self::createStub(InstalledAppDetailsTransformerInterface::class));

        $actual = $transformer->transform([InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'referenceIdAbsent' => [[], 'getReferenceId', null];
        yield 'referenceIdWrongType' => [[InstalledAppTransformerInterface::KEY_REFERENCE_ID => 42], 'getReferenceId', null];
        yield 'referenceIdValid' => [[InstalledAppTransformerInterface::KEY_REFERENCE_ID => 'test-reference-id'], 'getReferenceId', 'test-reference-id'];
        yield 'createdDateAbsent' => [[], 'getCreatedDate', null];
        yield 'createdDateWrongType' => [[InstalledAppTransformerInterface::KEY_CREATED_DATE => 42], 'getCreatedDate', null];
        yield 'createdDateValid' => [[InstalledAppTransformerInterface::KEY_CREATED_DATE => 'test-created-date'], 'getCreatedDate', 'test-created-date'];
        yield 'lastUpdatedDateAbsent' => [[], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateWrongType' => [[InstalledAppTransformerInterface::KEY_LAST_UPDATED_DATE => 42], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateValid' => [[InstalledAppTransformerInterface::KEY_LAST_UPDATED_DATE => 'test-last-updated-date'], 'getLastUpdatedDate', 'test-last-updated-date'];
        yield 'classificationsAbsent' => [[], 'getClassifications', []];
        yield 'classificationsWrongType' => [[InstalledAppTransformerInterface::KEY_CLASSIFICATIONS => 'not-array'], 'getClassifications', []];
        yield 'classificationsValid' => [[InstalledAppTransformerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 42, 'test-classifications-2']], 'getClassifications', ['test-classifications-1', 'test-classifications-2']];
        yield 'principalTypeAbsent' => [[], 'getPrincipalType', null];
        yield 'principalTypeWrongType' => [[InstalledAppTransformerInterface::KEY_PRINCIPAL_TYPE => 42], 'getPrincipalType', null];
        yield 'principalTypeValid' => [[InstalledAppTransformerInterface::KEY_PRINCIPAL_TYPE => 'test-principal-type'], 'getPrincipalType', 'test-principal-type'];
        yield 'restrictionTierAbsent' => [[], 'getRestrictionTier', null];
        yield 'restrictionTierWrongType' => [[InstalledAppTransformerInterface::KEY_RESTRICTION_TIER => 'not-int'], 'getRestrictionTier', null];
        yield 'restrictionTierValid' => [[InstalledAppTransformerInterface::KEY_RESTRICTION_TIER => 7], 'getRestrictionTier', 7];
        yield 'singleInstanceAbsent' => [[], 'getSingleInstance', null];
        yield 'singleInstanceWrongType' => [[InstalledAppTransformerInterface::KEY_SINGLE_INSTANCE => 'not-bool'], 'getSingleInstance', null];
        yield 'singleInstanceValid' => [[InstalledAppTransformerInterface::KEY_SINGLE_INSTANCE => true], 'getSingleInstance', true];
        yield 'allowedAbsent' => [[], 'getAllowed', []];
        yield 'allowedWrongType' => [[InstalledAppTransformerInterface::KEY_ALLOWED => 'not-array'], 'getAllowed', []];
        yield 'allowedValid' => [[InstalledAppTransformerInterface::KEY_ALLOWED => ['test-allowed-1', 42, 'test-allowed-2']], 'getAllowed', ['test-allowed-1', 'test-allowed-2']];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $owner = self::createStub(OwnerInterface::class);
        $notices = [self::createStub(NoticeInterface::class)];
        $ui = self::createStub(InstalledAppUiInterface::class);
        $iconImage = self::createStub(InstalledAppIconImageInterface::class);
        $details = self::createStub(InstalledAppDetailsInterface::class);
        $details->method('getOwner')->willReturn($owner);
        $details->method('getNotices')->willReturn($notices);
        $details->method('getUi')->willReturn($ui);
        $details->method('getIconImage')->willReturn($iconImage);

        $data = [InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id'] + [InstalledAppTransformerInterface::KEY_OWNER => []];
        $containerTransformer = self::createMock(InstalledAppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new InstalledAppTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($owner, $actual->getOwner());
        self::assertSame($notices, $actual->getNotices());
        self::assertSame($ui, $actual->getUi());
        self::assertSame($iconImage, $actual->getIconImage());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(InstalledAppDetailsInterface::class);
        $containerTransformer = self::createStub(InstalledAppDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new InstalledAppTransformer($containerTransformer);

        $actual = $transformer->transform([InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id'] + [InstalledAppTransformerInterface::KEY_OWNER => []]);

        self::assertNull($actual->getOwner());
        self::assertSame([], $actual->getNotices());
        self::assertNull($actual->getUi());
        self::assertNull($actual->getIconImage());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(InstalledAppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new InstalledAppTransformer($containerTransformer);

        $actual = $transformer->transform([InstalledAppTransformerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id']);

        self::assertNull($actual->getOwner());
        self::assertSame([], $actual->getNotices());
        self::assertNull($actual->getUi());
        self::assertNull($actual->getIconImage());
    }
}
