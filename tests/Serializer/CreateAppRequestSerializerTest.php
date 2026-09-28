<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AppOauthDefinition;
use ChristianBrown\SmartThings\Model\AppUiSettings;
use ChristianBrown\SmartThings\Model\CreateAppRequest;
use ChristianBrown\SmartThings\Model\CreateOrUpdateLambdaSmartAppRequest;
use ChristianBrown\SmartThings\Model\CreateOrUpdateWebhookSmartAppRequest;
use ChristianBrown\SmartThings\Model\IconImage;
use ChristianBrown\SmartThings\Serializer\CreateAppRequestSerializer;
use ChristianBrown\SmartThings\Serializer\CreateAppRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AppOauthDefinition::class)]
#[CoversClass(AppUiSettings::class)]
#[CoversClass(CreateAppRequest::class)]
#[CoversClass(CreateOrUpdateLambdaSmartAppRequest::class)]
#[CoversClass(CreateOrUpdateWebhookSmartAppRequest::class)]
#[CoversClass(IconImage::class)]
#[CoversClass(CreateAppRequestSerializer::class)]
final class CreateAppRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new CreateAppRequest('test-app-name', 'test-display-name', 'test-description', 'test-app-type', ['test-classifications-1', 'test-classifications-2']);

        $serializer = new CreateAppRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateAppRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                CreateAppRequestSerializerInterface::KEY_DISPLAY_NAME => 'test-display-name',
                CreateAppRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                CreateAppRequestSerializerInterface::KEY_APP_TYPE => 'test-app-type',
                CreateAppRequestSerializerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 'test-classifications-2'],
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new CreateAppRequest('test-app-name', 'test-display-name', 'test-description', 'test-app-type', ['test-classifications-1', 'test-classifications-2']))
            ->setSingleInstance(true)
            ->setIconImage((new IconImage())
                ->setUrl('test-url'))
            ->setPrincipalType('test-principal-type')
            ->setLambdaSmartApp(new CreateOrUpdateLambdaSmartAppRequest(['test-functions-1', 'test-functions-2']))
            ->setWebhookSmartApp(new CreateOrUpdateWebhookSmartAppRequest('test-target-url'))
            ->setOauth((new AppOauthDefinition())
                ->setClientName('test-client-name')
                ->setScope(['test-scope-1', 'test-scope-2'])
                ->setRedirectUris(['test-redirect-uris-1', 'test-redirect-uris-2']))
            ->setUi((new AppUiSettings(true, true))
                ->setPluginId('test-plugin-id')
                ->setPluginUri('test-plugin-uri'));

        $serializer = new CreateAppRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateAppRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                CreateAppRequestSerializerInterface::KEY_DISPLAY_NAME => 'test-display-name',
                CreateAppRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                CreateAppRequestSerializerInterface::KEY_SINGLE_INSTANCE => true,
                CreateAppRequestSerializerInterface::KEY_ICON_IMAGE => [
                    CreateAppRequestSerializerInterface::KEY_URL => 'test-url',
                ],
                CreateAppRequestSerializerInterface::KEY_APP_TYPE => 'test-app-type',
                CreateAppRequestSerializerInterface::KEY_PRINCIPAL_TYPE => 'test-principal-type',
                CreateAppRequestSerializerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 'test-classifications-2'],
                CreateAppRequestSerializerInterface::KEY_LAMBDA_SMART_APP => [
                    CreateAppRequestSerializerInterface::KEY_FUNCTIONS => ['test-functions-1', 'test-functions-2'],
                ],
                CreateAppRequestSerializerInterface::KEY_WEBHOOK_SMART_APP => [
                    CreateAppRequestSerializerInterface::KEY_TARGET_URL => 'test-target-url',
                ],
                CreateAppRequestSerializerInterface::KEY_OAUTH => [
                    CreateAppRequestSerializerInterface::KEY_CLIENT_NAME => 'test-client-name',
                    CreateAppRequestSerializerInterface::KEY_SCOPE => ['test-scope-1', 'test-scope-2'],
                    CreateAppRequestSerializerInterface::KEY_REDIRECT_URIS => ['test-redirect-uris-1', 'test-redirect-uris-2'],
                ],
                CreateAppRequestSerializerInterface::KEY_UI => [
                    CreateAppRequestSerializerInterface::KEY_PLUGIN_ID => 'test-plugin-id',
                    CreateAppRequestSerializerInterface::KEY_PLUGIN_URI => 'test-plugin-uri',
                    CreateAppRequestSerializerInterface::KEY_DASHBOARD_CARDS_ENABLED => true,
                    CreateAppRequestSerializerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true,
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new CreateAppRequest('test-app-name', 'test-display-name', 'test-description', 'test-app-type', ['test-classifications-1', 'test-classifications-2']))
            ->setSingleInstance(true)
            ->setIconImage(new IconImage())
            ->setPrincipalType('test-principal-type')
            ->setLambdaSmartApp(new CreateOrUpdateLambdaSmartAppRequest(['test-functions-1', 'test-functions-2']))
            ->setWebhookSmartApp(new CreateOrUpdateWebhookSmartAppRequest('test-target-url'))
            ->setOauth(new AppOauthDefinition())
            ->setUi(new AppUiSettings(true, true));

        $serializer = new CreateAppRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                CreateAppRequestSerializerInterface::KEY_APP_NAME => 'test-app-name',
                CreateAppRequestSerializerInterface::KEY_DISPLAY_NAME => 'test-display-name',
                CreateAppRequestSerializerInterface::KEY_DESCRIPTION => 'test-description',
                CreateAppRequestSerializerInterface::KEY_SINGLE_INSTANCE => true,
                CreateAppRequestSerializerInterface::KEY_ICON_IMAGE => [],
                CreateAppRequestSerializerInterface::KEY_APP_TYPE => 'test-app-type',
                CreateAppRequestSerializerInterface::KEY_PRINCIPAL_TYPE => 'test-principal-type',
                CreateAppRequestSerializerInterface::KEY_CLASSIFICATIONS => ['test-classifications-1', 'test-classifications-2'],
                CreateAppRequestSerializerInterface::KEY_LAMBDA_SMART_APP => [
                    CreateAppRequestSerializerInterface::KEY_FUNCTIONS => ['test-functions-1', 'test-functions-2'],
                ],
                CreateAppRequestSerializerInterface::KEY_WEBHOOK_SMART_APP => [
                    CreateAppRequestSerializerInterface::KEY_TARGET_URL => 'test-target-url',
                ],
                CreateAppRequestSerializerInterface::KEY_OAUTH => [],
                CreateAppRequestSerializerInterface::KEY_UI => [
                    CreateAppRequestSerializerInterface::KEY_DASHBOARD_CARDS_ENABLED => true,
                    CreateAppRequestSerializerInterface::KEY_PRE_INSTALL_DASHBOARD_CARDS_ENABLED => true,
                ],
            ],
            $actual
        );
    }
}
