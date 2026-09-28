<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AppUiSettings;
use ChristianBrown\SmartThings\Model\CreateOrUpdateLambdaSmartAppRequest;
use ChristianBrown\SmartThings\Model\CreateOrUpdateWebhookSmartAppRequest;
use ChristianBrown\SmartThings\Model\IconImage;
use ChristianBrown\SmartThings\Model\UpdateAppRequest;
use ChristianBrown\SmartThings\Serializer\UpdateAppRequestSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateAppRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppUiSettings::class)]
#[CoversClass(CreateOrUpdateLambdaSmartAppRequest::class)]
#[CoversClass(CreateOrUpdateWebhookSmartAppRequest::class)]
#[CoversClass(IconImage::class)]
#[CoversClass(UpdateAppRequest::class)]
#[CoversClass(UpdateAppRequestSerializer::class)]
final class UpdateAppRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new UpdateAppRequest('test-display-name', 'test-description', 'test-app-type', ['test-classifications-1', 'test-classifications-2']);

        $serializer = new UpdateAppRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateAppRequestSerializerInterface::KEY_DISPLAY_NAME => 'test-display-name',
                UpdateAppRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                UpdateAppRequestSerializerInterface::KEY_APP_TYPE => 'test-app-type',
                UpdateAppRequestSerializerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 'test-classifications-2'],
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new UpdateAppRequest('test-display-name', 'test-description', 'test-app-type', ['test-classifications-1', 'test-classifications-2']))
            ->setSingleInstance(true)
            ->setIconImage((new IconImage())
                ->setUrl('test-url'))
            ->setLambdaSmartApp(new CreateOrUpdateLambdaSmartAppRequest(['test-functions-1', 'test-functions-2']))
            ->setWebhookSmartApp(new CreateOrUpdateWebhookSmartAppRequest('test-target-url'))
            ->setUi((new AppUiSettings(true, true))
                ->setPluginId('test-plugin-id')
                ->setPluginUri('test-plugin-uri'));

        $serializer = new UpdateAppRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateAppRequestSerializerInterface::KEY_DISPLAY_NAME => 'test-display-name',
                UpdateAppRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                UpdateAppRequestSerializerInterface::KEY_SINGLE_INSTANCE => true,
                UpdateAppRequestSerializerInterface::KEY_ICON_IMAGE => [
                    UpdateAppRequestSerializerInterface::KEY_URL => 'test-url',
                ],
                UpdateAppRequestSerializerInterface::KEY_APP_TYPE => 'test-app-type',
                UpdateAppRequestSerializerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 'test-classifications-2'],
                UpdateAppRequestSerializerInterface::KEY_LAMBDA_SMART_APP => [
                    UpdateAppRequestSerializerInterface::KEY_FUNCTIONS => ['test-functions-1', 'test-functions-2'],
                ],
                UpdateAppRequestSerializerInterface::KEY_WEBHOOK_SMART_APP => [
                    UpdateAppRequestSerializerInterface::KEY_TARGET_URL => 'test-target-url',
                ],
                UpdateAppRequestSerializerInterface::KEY_UI => [
                    UpdateAppRequestSerializerInterface::KEY_PLUGIN_ID => 'test-plugin-id',
                    UpdateAppRequestSerializerInterface::KEY_PLUGIN_URI => 'test-plugin-uri',
                    UpdateAppRequestSerializerInterface::KEY_DASHBOARD_CARDS_ENABLED => true,
                    UpdateAppRequestSerializerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true,
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new UpdateAppRequest('test-display-name', 'test-description', 'test-app-type', ['test-classifications-1', 'test-classifications-2']))
            ->setSingleInstance(true)
            ->setIconImage(new IconImage())
            ->setLambdaSmartApp(new CreateOrUpdateLambdaSmartAppRequest(['test-functions-1', 'test-functions-2']))
            ->setWebhookSmartApp(new CreateOrUpdateWebhookSmartAppRequest('test-target-url'))
            ->setUi(new AppUiSettings(true, true));

        $serializer = new UpdateAppRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                UpdateAppRequestSerializerInterface::KEY_DISPLAY_NAME => 'test-display-name',
                UpdateAppRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                UpdateAppRequestSerializerInterface::KEY_SINGLE_INSTANCE => true,
                UpdateAppRequestSerializerInterface::KEY_ICON_IMAGE => [],
                UpdateAppRequestSerializerInterface::KEY_APP_TYPE => 'test-app-type',
                UpdateAppRequestSerializerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 'test-classifications-2'],
                UpdateAppRequestSerializerInterface::KEY_LAMBDA_SMART_APP => [
                    UpdateAppRequestSerializerInterface::KEY_FUNCTIONS => ['test-functions-1', 'test-functions-2'],
                ],
                UpdateAppRequestSerializerInterface::KEY_WEBHOOK_SMART_APP => [
                    UpdateAppRequestSerializerInterface::KEY_TARGET_URL => 'test-target-url',
                ],
                UpdateAppRequestSerializerInterface::KEY_UI => [
                    UpdateAppRequestSerializerInterface::KEY_DASHBOARD_CARDS_ENABLED => true,
                    UpdateAppRequestSerializerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true,
                ],
            ],
            $actual
        );
    }
}
