<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\App;
use ChristianBrown\SmartThings\Model\AppDetailsInterface;
use ChristianBrown\SmartThings\Model\AppUiSettingsInterface;
use ChristianBrown\SmartThings\Model\IconImageInterface;
use ChristianBrown\SmartThings\Model\LambdaSmartAppInterface;
use ChristianBrown\SmartThings\Model\OwnerInterface;
use ChristianBrown\SmartThings\Model\WebhookSmartAppInterface;
use ChristianBrown\SmartThings\Transformer\AppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppTransformer;
use ChristianBrown\SmartThings\Transformer\AppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(App::class)]
#[CoversClass(AppTransformer::class)]
final class AppTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new AppTransformer(self::createStub(AppDetailsTransformerInterface::class));

        $actual = $transformer->transform([AppTransformerInterface::KEY_APP_ID => 'test-app-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'principalTypeAbsent' => [[], 'getPrincipalType', null];
        yield 'principalTypeWrongType' => [[AppTransformerInterface::KEY_PRINCIPAL_TYPE => 42], 'getPrincipalType', null];
        yield 'principalTypeValid' => [[AppTransformerInterface::KEY_PRINCIPAL_TYPE => 'test-principal-type'], 'getPrincipalType', 'test-principal-type'];
        yield 'classificationsAbsent' => [[], 'getClassifications', []];
        yield 'classificationsWrongType' => [[AppTransformerInterface::KEY_CLASSIFICATIONS => 'not-array'], 'getClassifications', []];
        yield 'classificationsValid' => [[AppTransformerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 42, 'test-classifications-2']], 'getClassifications', ['test-classifications-1', 'test-classifications-2']];
        yield 'descriptionAbsent' => [[], 'getDescription', null];
        yield 'descriptionWrongType' => [[AppTransformerInterface::KEY_DESCRIPTION => 42], 'getDescription', null];
        yield 'descriptionValid' => [[AppTransformerInterface::KEY_DESCRIPTION => 'test-description'], 'getDescription', 'test-description'];
        yield 'singleInstanceAbsent' => [[], 'getSingleInstance', null];
        yield 'singleInstanceWrongType' => [[AppTransformerInterface::KEY_SINGLE_INSTANCE => 'not-bool'], 'getSingleInstance', null];
        yield 'singleInstanceValid' => [[AppTransformerInterface::KEY_SINGLE_INSTANCE => true], 'getSingleInstance', true];
        yield 'installMetadataAbsent' => [[], 'getInstallMetadata', []];
        yield 'installMetadataWrongType' => [[AppTransformerInterface::KEY_INSTALL_METADATA => 'not-array'], 'getInstallMetadata', []];
        yield 'installMetadataValid' => [[AppTransformerInterface::KEY_INSTALL_METADATA => ['test-install-metadata-key' => 'test-value', 'skipped' => 42]], 'getInstallMetadata', ['test-install-metadata-key' => 'test-value']];
        yield 'createdDateAbsent' => [[], 'getCreatedDate', null];
        yield 'createdDateWrongType' => [[AppTransformerInterface::KEY_CREATED_DATE => 42], 'getCreatedDate', null];
        yield 'createdDateValid' => [[AppTransformerInterface::KEY_CREATED_DATE => 'test-created-date'], 'getCreatedDate', 'test-created-date'];
        yield 'lastUpdatedDateAbsent' => [[], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateWrongType' => [[AppTransformerInterface::KEY_LAST_UPDATED_DATE => 42], 'getLastUpdatedDate', null];
        yield 'lastUpdatedDateValid' => [[AppTransformerInterface::KEY_LAST_UPDATED_DATE => 'test-last-updated-date'], 'getLastUpdatedDate', 'test-last-updated-date'];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $iconImage = self::createStub(IconImageInterface::class);
        $owner = self::createStub(OwnerInterface::class);
        $lambdaSmartApp = self::createStub(LambdaSmartAppInterface::class);
        $webhookSmartApp = self::createStub(WebhookSmartAppInterface::class);
        $ui = self::createStub(AppUiSettingsInterface::class);
        $details = self::createStub(AppDetailsInterface::class);
        $details->method('getIconImage')->willReturn($iconImage);
        $details->method('getOwner')->willReturn($owner);
        $details->method('getLambdaSmartApp')->willReturn($lambdaSmartApp);
        $details->method('getWebhookSmartApp')->willReturn($webhookSmartApp);
        $details->method('getUi')->willReturn($ui);

        $data = [AppTransformerInterface::KEY_APP_ID => 'test-app-id'] + [AppTransformerInterface::KEY_ICON_IMAGE => []];
        $containerTransformer = self::createMock(AppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new AppTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($iconImage, $actual->getIconImage());
        self::assertSame($owner, $actual->getOwner());
        self::assertSame($lambdaSmartApp, $actual->getLambdaSmartApp());
        self::assertSame($webhookSmartApp, $actual->getWebhookSmartApp());
        self::assertSame($ui, $actual->getUi());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(AppDetailsInterface::class);
        $containerTransformer = self::createStub(AppDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new AppTransformer($containerTransformer);

        $actual = $transformer->transform([AppTransformerInterface::KEY_APP_ID => 'test-app-id'] + [AppTransformerInterface::KEY_ICON_IMAGE => []]);

        self::assertNull($actual->getIconImage());
        self::assertNull($actual->getOwner());
        self::assertNull($actual->getLambdaSmartApp());
        self::assertNull($actual->getWebhookSmartApp());
        self::assertNull($actual->getUi());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(AppDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new AppTransformer($containerTransformer);

        $actual = $transformer->transform([AppTransformerInterface::KEY_APP_ID => 'test-app-id']);

        self::assertNull($actual->getIconImage());
        self::assertNull($actual->getOwner());
        self::assertNull($actual->getLambdaSmartApp());
        self::assertNull($actual->getWebhookSmartApp());
        self::assertNull($actual->getUi());
    }
}
