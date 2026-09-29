<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AppDetails;
use ChristianBrown\SmartThings\Model\AppUiSettingsInterface;
use ChristianBrown\SmartThings\Model\IconImageInterface;
use ChristianBrown\SmartThings\Model\LambdaSmartAppInterface;
use ChristianBrown\SmartThings\Model\OwnerInterface;
use ChristianBrown\SmartThings\Model\WebhookSmartAppInterface;
use ChristianBrown\SmartThings\Transformer\AppDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\AppDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\AppUiSettingsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\IconImageTransformerInterface;
use ChristianBrown\SmartThings\Transformer\LambdaSmartAppTransformerInterface;
use ChristianBrown\SmartThings\Transformer\OwnerTransformerInterface;
use ChristianBrown\SmartThings\Transformer\WebhookSmartAppTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppDetails::class)]
#[CoversClass(AppDetailsTransformer::class)]
final class AppDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $iconImageModel = self::createStub(IconImageInterface::class);
        $iconImageTransformer = self::createStub(IconImageTransformerInterface::class);
        $iconImageTransformer->method('transform')->willReturn($iconImageModel);
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $lambdaSmartAppModel = self::createStub(LambdaSmartAppInterface::class);
        $lambdaSmartAppTransformer = self::createStub(LambdaSmartAppTransformerInterface::class);
        $lambdaSmartAppTransformer->method('transform')->willReturn($lambdaSmartAppModel);
        $webhookSmartAppModel = self::createStub(WebhookSmartAppInterface::class);
        $webhookSmartAppTransformer = self::createStub(WebhookSmartAppTransformerInterface::class);
        $webhookSmartAppTransformer->method('transform')->willReturn($webhookSmartAppModel);
        $appUiSettingsModel = self::createStub(AppUiSettingsInterface::class);
        $appUiSettingsTransformer = self::createStub(AppUiSettingsTransformerInterface::class);
        $appUiSettingsTransformer->method('transform')->willReturn($appUiSettingsModel);
        $data = [
            AppDetailsTransformerInterface::KEY_ICON_IMAGE => ['test-nested'],
            AppDetailsTransformerInterface::KEY_OWNER => ['test-nested'],
            AppDetailsTransformerInterface::KEY_LAMBDA_SMART_APP => ['test-nested'],
            AppDetailsTransformerInterface::KEY_WEBHOOK_SMART_APP => ['test-nested'],
            AppDetailsTransformerInterface::KEY_UI => ['test-nested'],
        ];

        $transformer = new AppDetailsTransformer($iconImageTransformer, $ownerTransformer, $lambdaSmartAppTransformer, $webhookSmartAppTransformer, $appUiSettingsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($iconImageModel, $actual->getIconImage());
        self::assertSame($ownerModel, $actual->getOwner());
        self::assertSame($lambdaSmartAppModel, $actual->getLambdaSmartApp());
        self::assertSame($webhookSmartAppModel, $actual->getWebhookSmartApp());
        self::assertSame($appUiSettingsModel, $actual->getUi());
    }

    public function testTransformIconImage(): void
    {
        $iconImageModel = self::createStub(IconImageInterface::class);
        $iconImageTransformer = self::createStub(IconImageTransformerInterface::class);
        $iconImageTransformer->method('transform')->willReturn($iconImageModel);
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $lambdaSmartAppModel = self::createStub(LambdaSmartAppInterface::class);
        $lambdaSmartAppTransformer = self::createStub(LambdaSmartAppTransformerInterface::class);
        $lambdaSmartAppTransformer->method('transform')->willReturn($lambdaSmartAppModel);
        $webhookSmartAppModel = self::createStub(WebhookSmartAppInterface::class);
        $webhookSmartAppTransformer = self::createStub(WebhookSmartAppTransformerInterface::class);
        $webhookSmartAppTransformer->method('transform')->willReturn($webhookSmartAppModel);
        $appUiSettingsModel = self::createStub(AppUiSettingsInterface::class);
        $appUiSettingsTransformer = self::createStub(AppUiSettingsTransformerInterface::class);
        $appUiSettingsTransformer->method('transform')->willReturn($appUiSettingsModel);
        $transformer = new AppDetailsTransformer($iconImageTransformer, $ownerTransformer, $lambdaSmartAppTransformer, $webhookSmartAppTransformer, $appUiSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getIconImage());
        self::assertNull($transformer->transform($base + [AppDetailsTransformerInterface::KEY_ICON_IMAGE => 'test-not-array'])->getIconImage());
        self::assertSame($iconImageModel, $transformer->transform($base + [AppDetailsTransformerInterface::KEY_ICON_IMAGE => ['test-nested']])->getIconImage());
    }

    public function testTransformLambdaSmartApp(): void
    {
        $iconImageModel = self::createStub(IconImageInterface::class);
        $iconImageTransformer = self::createStub(IconImageTransformerInterface::class);
        $iconImageTransformer->method('transform')->willReturn($iconImageModel);
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $lambdaSmartAppModel = self::createStub(LambdaSmartAppInterface::class);
        $lambdaSmartAppTransformer = self::createStub(LambdaSmartAppTransformerInterface::class);
        $lambdaSmartAppTransformer->method('transform')->willReturn($lambdaSmartAppModel);
        $webhookSmartAppModel = self::createStub(WebhookSmartAppInterface::class);
        $webhookSmartAppTransformer = self::createStub(WebhookSmartAppTransformerInterface::class);
        $webhookSmartAppTransformer->method('transform')->willReturn($webhookSmartAppModel);
        $appUiSettingsModel = self::createStub(AppUiSettingsInterface::class);
        $appUiSettingsTransformer = self::createStub(AppUiSettingsTransformerInterface::class);
        $appUiSettingsTransformer->method('transform')->willReturn($appUiSettingsModel);
        $transformer = new AppDetailsTransformer($iconImageTransformer, $ownerTransformer, $lambdaSmartAppTransformer, $webhookSmartAppTransformer, $appUiSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getLambdaSmartApp());
        self::assertNull($transformer->transform($base + [AppDetailsTransformerInterface::KEY_LAMBDA_SMART_APP => 'test-not-array'])->getLambdaSmartApp());
        self::assertSame($lambdaSmartAppModel, $transformer->transform($base + [AppDetailsTransformerInterface::KEY_LAMBDA_SMART_APP => ['test-nested']])->getLambdaSmartApp());
    }

    public function testTransformOwner(): void
    {
        $iconImageModel = self::createStub(IconImageInterface::class);
        $iconImageTransformer = self::createStub(IconImageTransformerInterface::class);
        $iconImageTransformer->method('transform')->willReturn($iconImageModel);
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $lambdaSmartAppModel = self::createStub(LambdaSmartAppInterface::class);
        $lambdaSmartAppTransformer = self::createStub(LambdaSmartAppTransformerInterface::class);
        $lambdaSmartAppTransformer->method('transform')->willReturn($lambdaSmartAppModel);
        $webhookSmartAppModel = self::createStub(WebhookSmartAppInterface::class);
        $webhookSmartAppTransformer = self::createStub(WebhookSmartAppTransformerInterface::class);
        $webhookSmartAppTransformer->method('transform')->willReturn($webhookSmartAppModel);
        $appUiSettingsModel = self::createStub(AppUiSettingsInterface::class);
        $appUiSettingsTransformer = self::createStub(AppUiSettingsTransformerInterface::class);
        $appUiSettingsTransformer->method('transform')->willReturn($appUiSettingsModel);
        $transformer = new AppDetailsTransformer($iconImageTransformer, $ownerTransformer, $lambdaSmartAppTransformer, $webhookSmartAppTransformer, $appUiSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getOwner());
        self::assertNull($transformer->transform($base + [AppDetailsTransformerInterface::KEY_OWNER => 'test-not-array'])->getOwner());
        self::assertSame($ownerModel, $transformer->transform($base + [AppDetailsTransformerInterface::KEY_OWNER => ['test-nested']])->getOwner());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $iconImageModel = self::createStub(IconImageInterface::class);
        $iconImageTransformer = self::createStub(IconImageTransformerInterface::class);
        $iconImageTransformer->method('transform')->willReturn($iconImageModel);
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $lambdaSmartAppModel = self::createStub(LambdaSmartAppInterface::class);
        $lambdaSmartAppTransformer = self::createStub(LambdaSmartAppTransformerInterface::class);
        $lambdaSmartAppTransformer->method('transform')->willReturn($lambdaSmartAppModel);
        $webhookSmartAppModel = self::createStub(WebhookSmartAppInterface::class);
        $webhookSmartAppTransformer = self::createStub(WebhookSmartAppTransformerInterface::class);
        $webhookSmartAppTransformer->method('transform')->willReturn($webhookSmartAppModel);
        $appUiSettingsModel = self::createStub(AppUiSettingsInterface::class);
        $appUiSettingsTransformer = self::createStub(AppUiSettingsTransformerInterface::class);
        $appUiSettingsTransformer->method('transform')->willReturn($appUiSettingsModel);
        $transformer = new AppDetailsTransformer($iconImageTransformer, $ownerTransformer, $lambdaSmartAppTransformer, $webhookSmartAppTransformer, $appUiSettingsTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getIconImage());
        self::assertNull($actual->getOwner());
        self::assertNull($actual->getLambdaSmartApp());
        self::assertNull($actual->getWebhookSmartApp());
        self::assertNull($actual->getUi());
    }

    public function testTransformUi(): void
    {
        $iconImageModel = self::createStub(IconImageInterface::class);
        $iconImageTransformer = self::createStub(IconImageTransformerInterface::class);
        $iconImageTransformer->method('transform')->willReturn($iconImageModel);
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $lambdaSmartAppModel = self::createStub(LambdaSmartAppInterface::class);
        $lambdaSmartAppTransformer = self::createStub(LambdaSmartAppTransformerInterface::class);
        $lambdaSmartAppTransformer->method('transform')->willReturn($lambdaSmartAppModel);
        $webhookSmartAppModel = self::createStub(WebhookSmartAppInterface::class);
        $webhookSmartAppTransformer = self::createStub(WebhookSmartAppTransformerInterface::class);
        $webhookSmartAppTransformer->method('transform')->willReturn($webhookSmartAppModel);
        $appUiSettingsModel = self::createStub(AppUiSettingsInterface::class);
        $appUiSettingsTransformer = self::createStub(AppUiSettingsTransformerInterface::class);
        $appUiSettingsTransformer->method('transform')->willReturn($appUiSettingsModel);
        $transformer = new AppDetailsTransformer($iconImageTransformer, $ownerTransformer, $lambdaSmartAppTransformer, $webhookSmartAppTransformer, $appUiSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getUi());
        self::assertNull($transformer->transform($base + [AppDetailsTransformerInterface::KEY_UI => 'test-not-array'])->getUi());
        self::assertSame($appUiSettingsModel, $transformer->transform($base + [AppDetailsTransformerInterface::KEY_UI => ['test-nested']])->getUi());
    }

    public function testTransformWebhookSmartApp(): void
    {
        $iconImageModel = self::createStub(IconImageInterface::class);
        $iconImageTransformer = self::createStub(IconImageTransformerInterface::class);
        $iconImageTransformer->method('transform')->willReturn($iconImageModel);
        $ownerModel = self::createStub(OwnerInterface::class);
        $ownerTransformer = self::createStub(OwnerTransformerInterface::class);
        $ownerTransformer->method('transform')->willReturn($ownerModel);
        $lambdaSmartAppModel = self::createStub(LambdaSmartAppInterface::class);
        $lambdaSmartAppTransformer = self::createStub(LambdaSmartAppTransformerInterface::class);
        $lambdaSmartAppTransformer->method('transform')->willReturn($lambdaSmartAppModel);
        $webhookSmartAppModel = self::createStub(WebhookSmartAppInterface::class);
        $webhookSmartAppTransformer = self::createStub(WebhookSmartAppTransformerInterface::class);
        $webhookSmartAppTransformer->method('transform')->willReturn($webhookSmartAppModel);
        $appUiSettingsModel = self::createStub(AppUiSettingsInterface::class);
        $appUiSettingsTransformer = self::createStub(AppUiSettingsTransformerInterface::class);
        $appUiSettingsTransformer->method('transform')->willReturn($appUiSettingsModel);
        $transformer = new AppDetailsTransformer($iconImageTransformer, $ownerTransformer, $lambdaSmartAppTransformer, $webhookSmartAppTransformer, $appUiSettingsTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getWebhookSmartApp());
        self::assertNull($transformer->transform($base + [AppDetailsTransformerInterface::KEY_WEBHOOK_SMART_APP => 'test-not-array'])->getWebhookSmartApp());
        self::assertSame($webhookSmartAppModel, $transformer->transform($base + [AppDetailsTransformerInterface::KEY_WEBHOOK_SMART_APP => ['test-nested']])->getWebhookSmartApp());
    }
}
